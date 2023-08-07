import subprocess
import time
import sys


def check_openssl_installed():
    try:
        subprocess.run(["openssl", "version"], stdout=subprocess.PIPE, stderr=subprocess.PIPE, check=True)
    except FileNotFoundError:
        print("Error: OpenSSL is not installed.")
        sys.exit(1)
    except subprocess.CalledProcessError:
        print("Error: OpenSSL is installed, but there was an issue running it.")
        sys.exit(1)
    return True

def generate_key_pair():
    private_key = subprocess.run(["openssl", "genrsa", "RSA", "-out", "keypair.pem", "2048"],
                                 text=True, capture_output=True)
    # just to be sure
    time.sleep(1)

    subprocess.run(["openssl", "rsa", "-in", "private_key.pem", "-pubout", "-out", "public_key.pem"],
                   text=True, capture_output=True)

    with open("private_key.pem", "r") as private_key_file:
        private_key = private_key_file.read()
    with open("public_key.pem", "r") as public_key_file:
        public_key = public_key_file.read()

    subprocess.run(["rm", "private_key.pem"])
    subprocess.run(["rm", "public_key.pem"])

    return private_key, public_key

def write_to_env(private_key, public_key):
    with open(".env", "a") as env_file:
        env_file.write(f"LTI13_RSA_PRIVATE_KEY=\"{private_key}\"\n")
        env_file.write(f"LTI13_RSA_PUBLIC_KEY=\"{public_key}\"\n")

def check_env():
    with open(".env", "r") as file:
        lines = file.readlines()
        for line in lines:
            if "LTI13_RSA_PRIVATE_KEY" in line:
                return True
        return False

def main():
    if check_openssl_installed and not check_env():
        public_key, private_key = generate_key_pair()
        write_to_env(private_key, public_key)
        write_to_env(private_key, public_key)
        print("LTI 1.3 RS256 key pair generated and written to .env file.")
    else:
        print("LTI 1.3 RS256 key pair already exists in .env file.")

if __name__ == "__main__":
    main()
