from flask import Flask, render_template

app = Flask(__name__)

@app.route('/visitor-count')
def index():
    # Đếm số dòng trong tệp Access Logs
    try:
        with open('C:/xampp/apache/logs/access.log', 'r') as file:
            access_log_count = sum(1 for line in file)
    except FileNotFoundError:
        access_log_count = 0
    return render_template('index.php', access_log_count=access_log_count)

if __name__ == '__main__':
    app.run(debug=True)
