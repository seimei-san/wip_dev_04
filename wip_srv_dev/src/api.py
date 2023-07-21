#################################################
### API receiving the message from Chatbot  #####
#################################################


from src import app
from flask import render_template, request, redirect
import json

from src import ai
from src import chat_msg_processor_sym
from src import mongo_functions
from src import ai_msg_processor
from src.mysql_functions import MySqlDb


@app.route('/')
def index():
    print("index")
    msg = "Hello world from WIP SERVER!!"
    return render_template('index.html', text=msg)


##########################
# API for receiving messags from Symphony Chatbot
##########################
@app.route('/api/v1/msg/sym', methods=["POST"])
def insert_msgs():
    chat_sys = "SYM"
    if request.method == "POST":
        print("api.py: Method=POST")
    else:
        print("api.py: Methed!=POST")
        return render_template('index.html')
    
    chat_msg_processor_sym.msg_processor_sym(chat_sys, request.data)

 

    return render_template('index.html')



