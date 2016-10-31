Shopping Cart API Based
=======

It is a basic api based Shopping Cart system.

Installation guide lines
------------------------ 
<ol> 
        <li> Requirments :
		<ol>
			<li>Globally working PhpUnit to run test cases.</li> 
		</ol> 
	</li>

	<li>
		Update the host,username and password in <strong>database.php</strong> file located in <i>/class/</i> folder. 
	</li>
	<li>    
                Create a database called <strong>"shoppingkart"<strong> with the above database user. 
        </li>

	<li>
                Import data from <strong>shoppingkartDB.sql</strong> file.
	</li>

	<li>
		API returns following format:<br />
                    {"code":"","message":"","data":""}<br />
                Code: This is for returning error or success code. Usually  success code is in multiples of 10.<br />
                Message: This is for success or error message.<br />
                Data: This contains data requested by API.
	</li>
</ol>

