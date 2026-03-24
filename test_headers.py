import urllib.request
import sys

try:
    response = urllib.request.urlopen('http://127.0.0.1:8000/login')
    print("STATUS:", response.getcode())
    print("HEADERS:")
    for key, value in response.info().items():
        print(f"{key}: {value}")
except Exception as e:
    print(f"Error: {e}")
