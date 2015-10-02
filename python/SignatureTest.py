import unittest
from Signature import Signature

class TestSignature(unittest.TestCase):

    secret = "TWFGC9YBBsj8FaQ%N4v6hmfzjXK6yqR6rEsvHfkLfwIUKCk@ngvWZ7CqBfC7G4I"

    def _emulate_get_request(self):
        return  {"frontend": "9aho8o1bv2r7uqdtbpt7kq0l91",
                 "signature": {
                 "signed": "frontend",
                 "nonce": "2GgVoa6pnjtZ4ozEKALjkuP1TAmSD9RJ",
                 "token": "039957036d03477b557356a0897683165c33efdb"}}

    def _emulate_post_request(self):
        return {    'user_id' : 12345,
                    'email' : "mail@email.com",
                    'phone' : "+919876543210"}

    def test_generate_signature(self):
        nonce = "F6LAN4jmikVPqNllhwnHnEvtXH0obTY4"
        s = Signature(TestSignature.secret)
        signed_request = s.generate(self._emulate_post_request(),nonce)
        self.assertEqual(signed_request['signature']['token'],'987a82c940ccde6adc557a2d6b564a61488d3605')

    def test_validate_signature(self):
        s = Signature(TestSignature.secret)
        self.assertTrue(s.validate(self._emulate_get_request()))

if __name__ == '__main__' :
    unittest.main()
