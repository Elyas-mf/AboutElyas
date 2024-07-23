from flask import Flask, jsonify
from flask_cors import CORS
import pandas as pd
import matplotlib.pyplot as plt
import io
import base64
import mysql.connector
from mysql.connector import Error

app = Flask(__name__)
CORS(app)  # Enable CORS for all routes

# Set the Matplotlib backend to 'Agg' for non-GUI rendering
plt.switch_backend('Agg')

# Database connection
def get_db_connection():
    try:
        conn = mysql.connector.connect(
            host='localhost',
            user='root',  # Update with your MySQL username
            password='',  # Update with your MySQL password
            database='contactform'
        )
        if conn.is_connected():
            return conn
    except Error as e:
        print(f"Error: {e}")
        return None

@app.route('/api/time_series', methods=['GET'])
def time_series():
    conn = get_db_connection()
    if conn is None:
        return jsonify({'error': 'Failed to connect to database'}), 500

    cursor = conn.cursor(dictionary=True)
    query = "SELECT date, action_type FROM action_log"
    cursor.execute(query)
    result = cursor.fetchall()
    cursor.close()
    conn.close()

    # Convert result to a pandas DataFrame
    df = pd.DataFrame(result)

    # Convert date to datetime and set as index
    df['date'] = pd.to_datetime(df['date'], errors='coerce')
    df.dropna(subset=['date'], inplace=True)
    df.set_index('date', inplace=True)

    # Resample and count actions per day
    df_visits = df[df['action_type'] == 'visit'].resample('D').size()
    df_downloads = df[df['action_type'] == 'download'].resample('D').size()

    # Create the plot
    plt.figure(figsize=(10, 5))
    plt.plot(df_visits, label='Visits', marker='o')
    plt.plot(df_downloads, label='Downloads', marker='x')
    plt.title('Daily Visits and Downloads')
    plt.xlabel('Date')
    plt.ylabel('Count')
    plt.legend()
    plt.grid(True)

    # Save the plot to a BytesIO object
    img = io.BytesIO()
    plt.savefig(img, format='png')
    img.seek(0)
    plt.close()

    # Encode the image as a base64 string
    img_base64 = base64.b64encode(img.getvalue()).decode('utf-8')

    return jsonify({'plot': img_base64})

if __name__ == '__main__':
    app.run(debug=True)
