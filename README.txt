Guide on how to use (Login/Register):

1. Make a redirect to accounts.notesnetwork.org/<client_id>?next=<current_url>&sess_id=<session_id_to_write_in>

2. After successfull login/registration, information will be POSTed to the redirect_uri of the client (client_id). It will include the session id.

3. Deal with the posted info by writing it in the related session id.