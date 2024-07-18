from flask import Flask, render_template
from flask_socketio import SocketIO, emit

app = Flask(__name__)
app.config['SECRET_KEY'] = 'secret!'
socketio = SocketIO(app)

# Biến để lưu số người truy cập trực tiếp
connected_users = 0

@app.route('/')
def index():
    return render_template('index.php')

@socketio.on('connect')
def handle_connect():
    global connected_users
    connected_users += 1
    emit('user_count', connected_users, broadcast=True)

@socketio.on('disconnect')
def handle_disconnect():
    global connected_users
    connected_users -= 1
    emit('user_count', connected_users, broadcast=True)

if __name__ == '__main__':
    socketio.run(app, debug=True)
