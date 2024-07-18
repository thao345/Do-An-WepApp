from flask import Flask, render_template
import os
from flask import Flask
from flask_socketio import SocketIO

app = Flask(__name__)
socketio = SocketIO(app)

app = Flask(__name__)

@socketio.on('connect')
def handle_connect():
    print('Client connected')
@app.route('/visitor-count')
def index():
    # Đường dẫn tới thư mục chứa tệp log
    log_directory = 'C:/xampp/apache/logs/'

    # Kiểm tra xem tệp log có tồn tại hay không
    log_path = os.path.join(log_directory, 'access.log')
    if os.path.exists(log_path):
        try:
            with open(log_path, 'r') as file:
                access_log_count = sum(1 for line in file)
        except FileNotFoundError:
            access_log_count = 0
    else:
        access_log_count = 0

    return render_template('index.php', access_log_count=access_log_count)

if __name__ == '__main__':
    app.run(debug=True)
