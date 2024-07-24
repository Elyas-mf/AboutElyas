from flask import Flask, jsonify
from flask_cors import CORS
import mysql.connector
import pandas as pd
import matplotlib.pyplot as plt
import base64
from io import BytesIO
from datetime import datetime, timedelta

app = Flask(__name__)
CORS(app)  # This will enable CORS for all routes

# Use Agg backend for headless environments
plt.switch_backend('Agg')

def get_db_connection():
    return mysql.connector.connect(
        host="localhost",
        user="root",
        password="",  # Replace with your password if you have one
        database="contactform"
    )

@app.route('/api/time_series')
def time_series():
    conn = get_db_connection()
    
    query = "SELECT action_type, date FROM action_log"
    df = pd.read_sql(query, conn)
    conn.close()

    df['date'] = pd.to_datetime(df['date'])
    df.set_index('date', inplace=True)
    df.sort_index(inplace=True)

    # Get the current date
    today = datetime.now().date()
    start_date = datetime(today.year, today.month, today.day, 0, 0, 0)
    end_date = datetime(today.year, today.month, today.day, 23, 59, 59)

    # Debug statements to check date range
    print(f"Data available from {df.index.min()} to {df.index.max()}")
    print(f"Filtering data from {start_date} to {end_date}")

    # Filter data to the specified range
    df_filtered = df[(df.index >= start_date) & (df.index <= end_date)]

    # Group by hour and action type, then count occurrences
    df_grouped = df_filtered.groupby([pd.Grouper(freq='H'), 'action_type']).size().unstack(fill_value=0)

    # Create a DataFrame with all hours in the specified range
    all_hours = pd.date_range(start=start_date, end=end_date, freq='H')
    df_all_hours = pd.DataFrame(index=all_hours)
    
    # Merge the grouped data with the all_hours DataFrame to ensure all hours are included
    df_merged = df_all_hours.merge(df_grouped, left_index=True, right_index=True, how='left').fillna(0)

    print(f"Resampled DataFrame with all hours:\n{df_merged}")

    # Apply custom style
    plt.style.use('dark_background')
    colors = plt.cm.tab10.colors

    fig, ax = plt.subplots(figsize=(12, 6))

    for idx, action_type in enumerate(df_merged.columns):
        df_merged[action_type].plot(ax=ax, label=action_type, color=colors[idx % len(colors)], linewidth=2, marker='o')

    plt.title(f'Hourly Action Counts for {today.strftime("%B %d, %Y")}', fontsize=16, fontweight='bold', color='white')
    plt.xlabel('Time', fontsize=14, color='white')
    plt.ylabel('Count', fontsize=14, color='white')
    plt.legend(title='Action Type', title_fontsize='13', fontsize='11')
    plt.xticks(rotation=45, color='white')
    plt.yticks(color='white')
    
    # Customize x-axis to show hours
    ax.set_xlim([start_date, end_date])
    ax.xaxis.set_major_formatter(plt.FixedFormatter(all_hours.strftime("%H:%M")))

    # Customize the background color
    ax.set_facecolor('#161a2d')
    fig.patch.set_facecolor('#161a2d')
    fig.patch.set_alpha(1.0)

    # Add grid
    ax.grid(True, which='both', linestyle='--', linewidth=0.5, color='gray')

    buf = BytesIO()
    plt.savefig(buf, format='png')
    buf.seek(0)
    image_base64 = base64.b64encode(buf.getvalue()).decode('utf-8')
    plt.close(fig)

    return jsonify({'plot': image_base64})

if __name__ == '__main__':
    app.run(debug=True)
