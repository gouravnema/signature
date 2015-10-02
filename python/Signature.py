from hashlib import sha1

class Signature() :

    def __init__(self,secret):
        self.secret = secret

    def validate(self,request):
        keys = request['signature']['signed'].split(',')
        signing_string = ''
        for key in keys :
            signing_string += request[key]
        token = sha1(signing_string + request['signature']['nonce'] + self.secret).hexdigest()
        return token == request['signature']['token']

    def generate(self,request,nonce):
        signed = []
        signing_string = ""
        for  key in request :
            signed.append(key)
            signing_string += str(request[key])
        signing_string += nonce + self.secret
        request["signature"] ={
                    "signed":",".join(signed),
                    "token": sha1(signing_string ).hexdigest(),
                    "nonce" : nonce}
        return request
