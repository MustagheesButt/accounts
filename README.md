## Guide On Using the Central Login System:

Using our central login system is quite simple. Just follow these steps:

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

3. You can get your `CLIENT_ID` by registering your application at NotesNetwork Accounts. For now you have to contact the admins to get your application registered.

4. `scope` is the data you get in response, if the login/registration is successfull. They are separated by a dot `.`. You will not get password in any case. Following are the fields you can include in scope:

-- TODO --

5. In your `loginCallback`, you will get user data in JSON format using `response`. You probably want to `POST` it to your backend to get the user registerd or logged in to your site, set session and whatever.

That would be all for now :)
