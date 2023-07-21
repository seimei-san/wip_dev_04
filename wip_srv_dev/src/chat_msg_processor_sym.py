#########################################################################
#### Process the messages from Chatbot in order to supply to ChatGPT  ###
#########################################################################

import json
from bs4 import BeautifulSoup
import datetime
import re
from src import ai_msg_processor
from src.mysql_functions import MySqlDb
from src import mongo_functions
from src import ai
from src import chat_msg_filter


mysqldb = MySqlDb()




##########################################
# Process Message from SYM
##########################################

def msg_processor_sym(chat_sys, msg_org):
  msg_decoded = json.loads(msg_org.decode('utf-8'))

  ########### Check Target User's Message or not and store user_profile
  user_profile = get_user_profile_sym(chat_sys, msg_decoded) 
  if (len(user_profile) == 0):
      print('Exit msg_processor bcz not target user')
      return

  ########### Format Sym Chat Message for Processing
  msg_only = msg_removetag_sym(msg_decoded)


  if (chat_msg_filter.msg_req_detector(msg_only) == False):
     print("Exit msg_processor bcz not request message")
     return
  else:
     print("THIS IS A REQ MSG")
  
  user_info = get_user_info_sym(user_profile[0])[0]

  msg_in = msg_formatter_sym(user_info['user_id'], user_info['domain_id'], chat_sys, "user", msg_decoded, msg_only)

  print("AFTER_MSG_FORMATTER: ", msg_in)


  print("######### Requesting AI #########")
  ########## Send Formatted Sym Chat Message to GhatGPT 
  ai_response_org = ai.ask_ChatCompletion(ai.prompt_generator(msg_in))
  print("AI_RESPONSE: ", ai_response_org)
  print("######### AI Response ##########")


  if len(ai_response_org) == 0:
      print("api.py: ERRROR: AI response is empty!")
  else:
      ########## store Message with Attributes into MongoDB
      ai_response = ai_msg_processor.ai_msg_parser(msg_in['domain_id'], msg_in['user_id'], msg_in['chat_sys'], msg_in['display_name'], msg_in['chat_user_id'], msg_in['conversation_id'], "", msg_in['message_id'], msg_in['date'], msg_in['time'], ai_response_org, msg_in['message'])
      doc_id = mongo_functions.insert_msg(ai_response)

      ######### store Scores based on AI Response into MySQL
      score = ai_msg_processor.ai_msg_score(msg_in['domain_id'], msg_in['user_id'], msg_in['chat_sys'], msg_in['display_name'], msg_in['chat_user_id'], doc_id, msg_in['conversation_id'], "", msg_in['message_id'], msg_in['date'], msg_in['time'], ai_response_org)
      mysqldb = MySqlDb()
      try:
          result = mysqldb.insert_wip_score(score)
      except Exception as e:
          print("api.py: ERROR: cannot insert score into MySQL: %s", e)

      print('######### Completed #########')




####################################
# get User Profile for Target user
###################################
def get_user_profile_sym(chat_sys, msg_decoded):
  chat_user_id = msg_decoded.get('user_id')
  user_profile = mysqldb.fetch_target_user_profile(chat_sys, chat_user_id)
  return user_profile


###########################
# remove HTML Tags
###########################
def msg_removetag_sym(msg_decoded):
  msg_org = msg_decoded.get('message')
  msg_org = msg_org.replace('</li>', '。')
  msg_notag = re.sub(re.compile('<.*?>'), '', msg_org)
  return msg_notag


def get_user_info_sym(user_profile):
   user_id = user_profile['user_id']
   user_info = mysqldb.fetch_target_user_info(user_id)
   return user_info
   


###########################
# format msg for injecting to AI
###########################
def msg_formatter_sym(user_id, domain_id, chat_sys, origin, msg_decoded, msg_notag):

  display_name = msg_decoded.get('display_name')
  chat_user_id = msg_decoded.get('user_id')
  conversation_id = msg_decoded.get('conversation_id')
  thread_id = ""
  message_id = msg_decoded.get('message_id')
  datetime_stamp = datetime.datetime.fromtimestamp(msg_decoded.get('timestamp') / 1000)
  date = datetime_stamp.date().strftime('%Y-%m-%d')
  time = datetime_stamp.time().strftime('%X')

  
  msg_json = {'domain_id': domain_id, 'user_id': user_id, 'chat_sys': chat_sys, 'origin': origin, 'display_name': display_name, 'chat_user_id': chat_user_id, 'conversation_id': conversation_id, 'thread_id': thread_id, 'message_id': message_id, 'date': date, 'time': time, 'message': msg_notag}
  return msg_json




if __name__ == "__main__":
    
  # msg_org = b'{"display_name": "Symbot3 Kurosawa", "user_id": 349026222360289, "conversation_id": "elNBjhvc4uirR7ZEyB_7XH___ndWQpHtdA", "message_id": "9UY7BO9r5warSpNbiGK5L3___ndA8CMObQ", "timestamp": 1686832667889, "message": "<div data-format=\\"PresentationML\\" data-version=\\"2.0\\" class=\\"wysiwyg\\"><p>\\u305b\\u3044\\u3081\\u3044\\u3055\\u3093\\u3001\\u4eca\\u65e5\\u306e\\u5915\\u65b9\\u306e\\u6253\\u3061\\u5408\\u308f\\u305b\\u304a\\u9858\\u3044\\u3057\\u307e\\u3059\\u3002</p></div>"}'
  # tmp = msg_formatter_sym(msg_org)
  # print(tmp)
  print("Hi")