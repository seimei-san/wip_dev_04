import sys
sys.dont_write_bytecode = True

from src import app


if __name__ == '__main__':
    # app.run(debug=True)
    app.run(debug=True, port=5000, ssl_context=('./certs/wip_srv.crt', './certs/wip_srv.key'), host='0.0.0.0')