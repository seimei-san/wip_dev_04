def msg_formatter_sym(msg_decoded):
  domain_id = "ATHFWK8N"
  user_id = "FX0PKKOY420138QGA462"
  chat_sys = "SYM"
  orgin = 'user'
  display_name = msg_decoded.get('display_name')
  chat_user_id = msg_decoded.get('user_id')
  conversation_id = msg_decoded.get('conversation_id')
  thread_id = ""
  message_id = msg_decoded.get('message_id')
  datetime_stamp = datetime.datetime.fromtimestamp(msg_decoded.get('timestamp') / 1000)
  date = datetime_stamp.date().strftime('%Y-%m-%d')
  time = datetime_stamp.time().strftime('%X')
  message = msg_decoded.get('message')

  # Extract the message from Symphony presentationHTML format message
  # TODO need to capture text with multiple <p>
  msg_msg = BeautifulSoup(message, "html.parser").find('p').text
  
  msg_json = {'domain_id': domain_id, 'user_id': user_id, 'chat_sys': chat_sys, 'origin': orgin, 'display_name': display_name, 'chat_user_id': chat_user_id, 'conversation_id': conversation_id, 'thread_id': thread_id, 'message_id': message_id, 'date': date, 'time': time, 'message': msg_msg}
  return msg_json