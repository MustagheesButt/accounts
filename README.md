## Guide On Using the Central Login System:

Using our central login system is quite simple. There are 3 simple steps, listed below:

### 1. Register An App With NotesNetwork

Currently, it is all manual. So you need to ask an admin to get your app registered. For registering, you need to provide the following:

- App name
- A callback URL for receiving access token

After registration, you will recieve the following information:

- A Client ID
- An App Secret

### 2. Setup Application Frontend

1. Include our `NN-SDK.js` on the page(s) you want the users to login/register from. This is probably every page which has the Login/Register button.
```
<script type="text/javascript" src="https://accounts.notesnetwork.org/static/js/NN-SDK.js"></script>
```

2. Right after that, or in your main `script.js`, configure the SDK. It should follow the below pattern:
```
NN.init({
	client_id: <CLIENT_ID>,
	scope: "id.first_name.last_name.email",

	loginCallback: function (response) {
		// do something with response
	}
});
```

4. `scope` is the data you get in response, if the login/registration is successfull. They are separated by a dot `.`. You will not get password in any case. Following are the fields you can include in scope:

- id
- first_name
- middle_name
- last_name
- email
- username
- birthdate
- gender
- mobile_number

5. In your `loginCallback`, you will get user data in JSON format using `response`. You probably want to `POST` it to your backend to get the user registerd or logged in to your site, set session and whatever.

### 3. Setup Callback URL Page

In your web application, define a route, say `/receive_access_token`, for a callback page, say `receive_access_token.html`. It should be exactly the one you gave when registering your application with NotesNetwork. The contents of the page should be like:

#### In PHP

`receive_access_token.html`:
```
<div id="access_token"><?= $_GET['access_token'] ?></div>

<script type="text/javascript">
	window.opener.NN.recieve_token(document.getElementById('access_token').innerHTML, <?= ($_GET['callback'] == TRUE ? 'true' : 'false') ?>);
</script>
```

#### In Python/Flask:

route definition:
```
@app.route('receive_access_token', methods=['GET'])
def receive_access_token():
	return render_template("receive_access_token.html",
		access_token = request.args.get('access_token'),
		callback_status = request.args.get('callback')
		)
```

`receive_access_token.html`:
```
<div id="access_token">{{ access_token }}</div>

<script type="text/javascript">
	window.opener.NN.recieve_token(document.getElementById('access_token').innerHTML, {{ callback_status }});
</script>
```

That would be all for now :)
