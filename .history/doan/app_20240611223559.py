from flask import Flask, render_template
import subprocess

app = Flask(__name__)

@app.route('/')
def index():
    # Đếm số dòng trong tệp Access Logs
    access_log_count = subprocess.check_output(['wc', '-l', 'C:/xampp/apache/logs/access.log']).split()[0].decode('utf-8')
    return render_template('index.php', access_log_count=access_log_count)

if __name__ == '__main__':
    app.run(debug=True)