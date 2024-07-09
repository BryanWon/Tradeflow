from waitress import serve
from app import app  # Ensure this matches your Flask app import

if __name__ == '__main__':
    serve(app, host='0.0.0.0', port=5000)
