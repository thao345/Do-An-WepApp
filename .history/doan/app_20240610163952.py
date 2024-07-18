from flask import Flask, jsonify
from flask_socketio import SocketIO

app = Flask(__name__)
app.config['SECRET_KEY'] = 'secret!'
socketio = SocketIO(app, cors_allowed_origins="*")

# Biến để lưu số người truy cập trực tiếp
connected_users = 0

@app.route('/get_user_count')1
def get_user_count():
    return jsonify({'user_count': connected_users})

@socketio.on('connect')
def handle_connect():
    global connected_users
    connected_users += 1
    socketio.emit('user_count', connected_users, broadcast=True)

@socketio.on('disconnect')
def handle_disconnect():
    global connected_users
    connected_users -= 1
    socketio.emit('user_count', connected_users, broadcast=True)

if __name__ == '__main__':
    socketio.run(app, debug=True)
