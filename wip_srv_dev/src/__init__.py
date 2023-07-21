#!/usr/bin/env python3

from flask import Flask
from dotenv import load_dotenv

load_dotenv()

app = Flask(__name__, template_folder="../templates", static_folder="../static")

import src.api

