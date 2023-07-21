##################################################
### Generate and send the prompt to ChatGPT   ####
##################################################


import openai

from dotenv import load_dotenv
import os
import json

load_dotenv()

openai.organization=os.getenv('AI_ORG')
openai.api_key=os.getenv('AI_KEY')


#########################
# generate a prompt based on the received Chatbot mesasge
#########################
def prompt_generator(msgs_json):
    msg_in = []
    msg_in.append(msgs_json)
    prompt = []
    for msg in msg_in:
      speaker = msg['display_name']
      # msg_txt = speaker + 'は言いました。' + msg['message']
      msg_txt = msg['message']
      msg_json = {'role':'user', 'content': msg_txt}
      prompt.append(msg_json)

    if len(msgs_json) == 1:
      prompt_json = {'role':'user', 'content': os.getenv('AI_PROMPT_S')}
      prompt.append(prompt_json)
    else:
      prompt_json = {'role':'user', 'content': os.getenv('AI_PROMPT_M')}
      prompt.append(prompt_json)

    print("PROMPT: ", prompt)

    return prompt

##########################
# send the generated prompt to ChatGPT (ChatCompletion)
##########################
def ask_ChatCompletion(msgs_json):
    completion = openai.ChatCompletion.create(
        model = "gpt-3.5-turbo",
        messages = msgs_json,
        max_tokens = 1024,
        n = 1,
        stop = None,
        temperature = 0.5
    )
    response = completion.choices[0].message.content
    # response = completion
    return response


#########################
# This is not in use (Completion)
def ask_Completion(msg):
    completion = openai.Completion.create(
        model = "text-davinci-003",
        prompt = '',
      temperature=0.7,
      # max_tokens=1024,
      max_tokens=3000,
      top_p=1,
      frequency_penalty=0,
      presence_penalty=0
    )
    response = completion.choices[0].text
    return response
 



if __name__ == "__main__":

    msgs_json_sample = [
        {'display_name': 'Symbot3 Kurosawa', 'user_id': 349026222360289, 'conversation_id': 'elNBjhvc4uirR7ZEyB_7XH___ndWQpHtdA', 'message_id': 'xw3Yz6GNWRodlGrfN5ehCX___ndFkUpkbQ', 'timestamp': 1686754997659, 'message': '明日の夕方までに資料を作ってください'},
        {'display_name': 'Symbot3 Kurosawa', 'user_id': 349026222360289, 'conversation_id': 'elNBjhvc4uirR7ZEyB_7XH___ndWQpHtdA', 'message_id': 'xw3Yz6GNWRodlGrfN5ehCX___ndFkUpkbQ', 'timestamp': 1686754997659, 'message': '最悪、明日の11時まで'},
        {'display_name': 'Symbot3 Kurosawa', 'user_id': 349026222360289, 'conversation_id': 'elNBjhvc4uirR7ZEyB_7XH___ndWQpHtdA', 'message_id': 'xw3Yz6GNWRodlGrfN5ehCX___ndFkUpkbQ', 'timestamp': 1686754997659, 'message': '社長が会議で新商品を説明するために必要なんです。'}
        ]

    print(ask_ChatCompletion(prompt_generator(msgs_json_sample)))
    # print(ask_Completion())