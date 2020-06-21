import json
import os

if __name__ == "__main__":
            with open('heh.json', 'r') as f:
                json_string = f.read()
            res = json.loads(json_string)
            print(json.dumps(res, sort_keys=False, indent=4))
