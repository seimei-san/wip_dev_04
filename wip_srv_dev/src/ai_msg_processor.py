####################################################
#### Process the response messages from ChatGPT  ###
####################################################


# standard text in case of 5W2H elemenet cannot be found
who_to_do_none ='who to do: none'
what_to_do_none = 'what to do: none'
by_when_none = 'by when: none'
from_when_none = 'from when: none'
until_when_none = 'until when: none'
at_where_none = 'at where: none'
in_where_none = 'in where: none'
from_where_none = 'from where: none'
to_where_none = 'to where: none'
how_to_do_none = 'how to do: none'
how_much_none = 'how much: none'
how_many_none = 'how many: none'
who_to_do_lable_dash = "- who to do: "
why_none = 'why: none'

##################################################
# Parse the response message to extarct the results of 5W2H search in ChatGPT response Message in order to record into MongoDB
##################################################
def ai_msg_parser(domain_id, user_id, chat_sys, display_name, chat_user_id, conversation_id, thread_id, message_id, date, time, msg_ai, msg_org):
  # msg_ai = msg_ai.replace('\n','')
  msg_lower = msg_ai.lower()
  msg_lower_len = len(msg_lower)

  # The text need to be identified in the response and its length in order to extract response from ChatGPT
  if msg_lower.find(who_to_do_lable_dash) == -1:  # check the label has a dash or not
    who_to_do_label  = ['who to do: ', 11]
    what_to_do_label  = ['what to do: ', 12]
    by_when_label  = ['by when: ', 9]
    from_when_label  = ['from when: ', 11]
    until_when_label  = ['until when: ', 12]
    at_where_label  = ['at where: ', 10]
    in_where_label  = ['in where: ', 10]
    from_where_label  = ['from where: ', 12]
    to_where_label  = ['to where: ', 10]
    how_to_do_label  = ['how to do: ', 11]
    how_much_label  = ['how much: ', 10]
    how_many_label  = ['how many: ', 10]
    why_label  = ['why: ', 5]
  else:  
    who_to_do_label  = ['- who to do: ', 13]
    what_to_do_label  = ['- what to do: ', 14]
    by_when_label  = ['- by when: ', 11]
    from_when_label  = ['- from when: ', 13]
    until_when_label  = ['- until when: ', 14]
    at_where_label  = ['- at where: ', 12]
    in_where_label  = ['- in where: ', 12]
    from_where_label  = ['- from where: ', 14]
    to_where_label  = ['- to where: ', 12]
    how_to_do_label  = ['- how to do: ', 13]
    how_much_label  = ['- how much: ', 12]
    how_many_label  = ['- how many: ', 12]
    why_label  = ['- why: ', 7]

  # store the position of labels
  who_to_do_pos = msg_lower.find(who_to_do_label[0])
  by_when_pos = msg_lower.find(by_when_label[0])
  from_when_pos = msg_lower.find(from_when_label[0])
  until_when_pos = msg_lower.find(until_when_label[0])
  at_where_pos = msg_lower.find(at_where_label[0])
  in_where_pos = msg_lower.find(in_where_label[0])
  from_where_pos = msg_lower.find(from_where_label[0])
  to_where_pos = msg_lower.find(to_where_label[0])
  how_to_do_pos = msg_lower.find(how_to_do_label[0])
  how_much_pos = msg_lower.find(how_much_label[0])
  how_many_pos = msg_lower.find(how_many_label[0])
  what_to_do_pos = msg_lower.find(what_to_do_label[0])
  why_pos = msg_lower.find(why_label[0])
  
  # identify the end position of each statement and store it
  who_to_do_end = msg_lower.find('\n', who_to_do_pos)
  by_when_end = msg_lower.find('\n', by_when_pos)
  from_when_end = msg_lower.find('\n', from_when_pos)
  until_when_end = msg_lower.find('\n', until_when_pos)
  at_where_end = msg_lower.find('\n', at_where_pos)
  in_where_end = msg_lower.find('\n', in_where_pos)
  from_where_end = msg_lower.find('\n', from_where_pos)
  to_where_end = msg_lower.find('\n', to_where_pos)
  how_to_do_end = msg_lower.find('\n', how_to_do_pos)
  how_much_end = msg_lower.find('\n', how_much_pos)
  how_many_end = msg_lower.find('\n', how_many_pos)
  what_to_do_end = msg_lower.find('\n', what_to_do_pos)
  why_end = msg_lower.find('\n', why_pos)

  # identify the last element without \n and replace -1 with the length of the response
  who_to_do_end = who_to_do_end if who_to_do_end != -1 else msg_lower_len
  by_when_end = by_when_end if by_when_end != -1 else msg_lower_len
  from_when_end = from_when_end if from_when_end != -1 else msg_lower_len
  until_when_end = until_when_end if until_when_end != -1 else msg_lower_len
  at_where_end = at_where_end if at_where_end != -1 else msg_lower_len
  in_where_end = in_where_end if in_where_end != -1 else msg_lower_len
  from_where_end = from_where_end if from_where_end != -1 else msg_lower_len
  to_where_end = to_where_end if to_where_end != -1 else msg_lower_len
  how_to_do_end = how_to_do_end if how_to_do_end != -1 else msg_lower_len
  how_much_end = how_much_end if how_much_end != -1 else msg_lower_len
  how_many_end = how_many_end if how_many_end != -1 else msg_lower_len
  what_to_do_end = what_to_do_end if what_to_do_end != -1 else msg_lower_len
  why_end = why_end if why_end != -1 else msg_lower_len

  # extract the result of each element and store it 
  who_to_do = "none" if who_to_do_pos == -1 else msg_ai[who_to_do_pos + who_to_do_label[1]: who_to_do_end]
  by_when = "none" if by_when_pos == -1 else msg_ai[by_when_pos + by_when_label[1]: by_when_end]
  from_when = "none" if from_when_pos == -1 else msg_ai[from_when_pos + from_when_label[1]: from_when_end]
  until_when = "none" if until_when_pos == -1 else msg_ai[until_when_pos + until_when_label[1]: until_when_end]
  at_where = "none" if at_where_pos == -1 else msg_ai[at_where_pos + at_where_label[1]: at_where_end]
  in_where = "none" if in_where_pos == -1 else msg_ai[in_where_pos + in_where_label[1]: in_where_end]
  from_where = "none" if from_where_pos == -1 else msg_ai[from_where_pos + from_where_label[1]: from_where_end]
  to_where = "none" if to_where_pos == -1 else msg_ai[to_where_pos + to_where_label[1]: to_where_end]
  how_to_do = "none" if how_to_do_pos == -1 else msg_ai[how_to_do_pos + how_to_do_label[1]: how_to_do_end]
  how_much = "none" if how_much_pos == -1 else msg_ai[how_much_pos + how_much_label[1]: how_much_end]
  how_many = "none" if how_many_pos == -1 else msg_ai[how_many_pos + how_many_label[1]: how_many_end]
  what_to_do = "none" if what_to_do_pos == -1 else msg_ai[what_to_do_pos + what_to_do_label[1]: what_to_do_end]
  why = "none" if why_pos == -1 else msg_ai[why_pos + why_label[1]: why_end]
  

  # Return the results in JSON
  msg_parsed = {'domain_id': domain_id, 'user_id': user_id, 'chat_sys': chat_sys, 'origin': 'ai', 'display_name': display_name, 'chat_user_id': chat_user_id, 'conversation_id': conversation_id, 'thread_id': thread_id, 'message_id': message_id, 'date': date, 'time': time, 'who_to_do': who_to_do, 'by_when': by_when, 'from_when': from_when, 'until_when': until_when, 'at_where': at_where, 'in_where': in_where, 'from_where': from_where, 'to_where': to_where, 'how_to_do': how_to_do, 'how_much': how_much, 'how_many': how_many, 'what_to_do': what_to_do, 'why': why, 'message': msg_org}
  return msg_parsed

#######################################
# convert the results of 5W2H search from ChatGPT into a score 1 or 0
#######################################
def ai_msg_score(domain_id, user_id, chat_sys, display_name, chat_user_id, doc_id, conversation_id, thread_id, message_id, date, time, msg_ai):
  msg_lower = msg_ai.lower()
  who_to_do = 0 if msg_lower.find(who_to_do_none) != -1 else 1
  by_when = 0 if msg_lower.find(by_when_none) != -1 else 1
  from_when = 0 if msg_lower.find(from_when_none) != -1 else 1
  until_when = 0 if msg_lower.find(until_when_none) != -1 else 1
  at_where = 0 if msg_lower.find(at_where_none) != -1 else 1
  in_where = 0 if msg_lower.find(in_where_none) != -1 else 1
  from_where = 0 if msg_lower.find(from_where_none) != -1 else 1
  to_where = 0 if msg_lower.find(to_where_none) != -1 else 1
  how_to_do = 0 if msg_lower.find(how_to_do_none) != -1 else 1
  how_much = 0 if msg_lower.find(how_much_none) != -1 else 1
  how_many = 0 if msg_lower.find(how_many_none) != -1 else 1
  what_to_do = 0 if msg_lower.find(what_to_do_none) != -1 else 1
  why = 0 if msg_lower.find(why_none) != -1 else 1

  
  # Return the score in JSON for MySQL
  msg_score = {'domain_id': domain_id, 'user_id': user_id, 'chat_sys': chat_sys, 'origin': 'ai', 'display_name': display_name, 'chat_user_id': chat_user_id, 'doc_id': doc_id, 'conversation_id': conversation_id, 'thread_id': thread_id, 'message_id': message_id, 'date': date, 'time': time, 'who_to_do': who_to_do, 'by_when': by_when, 'from_when': from_when, 'until_when': until_when, 'at_where': at_where, 'in_where': in_where, 'from_where': from_where, 'to_where': to_where, 'how_to_do': how_to_do, 'how_much': how_much, 'how_many': how_many, 'what_to_do': what_to_do, 'why': why }
  return msg_score

if __name__ == "__main__":
  
  test_msg = '- Who to do: 山本さん (Mr. Yamamoto)\\n- By when: 今週金曜日までに (by the end of this week on Friday) \\n - Until when: none\\n- What to do: 資料を作成する (to create a document)\\n- At where: none\\n- In where: none\\n- To where: none\\n- How to do: none\\n- How much: none\\n- How many: none\\n- Why: none'
  # print(ai_msg_score("", "", "", "", "", "", test_msg))



