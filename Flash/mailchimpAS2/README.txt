TUTORIAL
Subscribe list users to a MailChimp mailing list via Flash and connecting directly to the MailChimp API

AUTHOR
Christian Cox, christiancox.com
christian@christiancox.com

SUMMARY
Use a Flash form to capture a user's first name, last name, and email address. Hardcode your MailChimp API key and list ID using ActionScript. Validate the email address; if valid, attempt listSubscribe() using serialized XML and the MailChimp API. Display a response message to the user.

TECHNOLOGY
Flash CS3, ActionScript 2.0

ASSUMPTIONS
Capturing only first name, last name, and email address.
Valid API Key 
    - find this by logging into your MailChimp account and going to "Account", the "API Keys & Info"
Valid List ID 
    - login to your MailChimp account, go to your lists and click "Unsubscribe form code" for the proper list.
    - in the URL generated, pick out the "id" parameter (that's the id you need, not the plain 
    OR 
    - find this by executing the lists() function 

input text fields: "firstName_txt", "lastName_txt", "email_txt".
submit button: "submit_mc".


PERMALINK
http://christiancox.com/?p=29

More Info on the MailChimp API can be found here:
http://www.mailchimp.com/api/


------ License -----------
Copyright (c) 2009 Christian Cox, christiancox.com, released under the MIT license

Permission is hereby granted, free of charge, to any person
obtaining a copy of this software and associated documentation
files (the "Software"), to deal in the Software without
restriction, including without limitation the rights to use,
copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the
Software is furnished to do so, subject to the following
conditions:

The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
OTHER DEALINGS IN THE SOFTWARE.
