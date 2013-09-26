#Validator

Adding a rule is simple

    $validator->addRule( $rule, $key = null, $error_if_invalid = null, $error_if_empty = null );
 
`$rule` The rule to add

`$key` The key in the array or property in the object to validate  

`$error_if_invalid` Error to set if the data supplied doesn't validate

`$error_if_empty` Error to set if the data supplied is empty

Having a separate error for invalid and empty data is convenient. For example, say you have a name field that you add rules to requiring it to be between 3 and 10 characters.  If a user entered 2 letters for their name and you just had an error stating "Please enter your name" the user can become confused. With this method you can have an error message when they leave a field empty stating "This field is required" and an error message when invalid data is supplied instructing them how ot fix it.

`$key`, `$error_if_invalid`, and `$error_if_empty` are optional arguments.  `$key` is only required if you are validating an array or object. When adding the first rule if `$key` is supplied the validator knows you are validating an array or object and will throw an exception if `$key` is left out of subsequent calls to `addRule()`. The reverse is also true.

---

##Form validation example

You have a comment form

	<form action="">
	    Name: <input type="text" name="comment[name]">
	    Email: <input type="text" name="comment[email]">
	    Comment: <textarea name="comment[text]"></textarea>
	    <input type="submit">
	</form>

To validate it:

1. Check for `$_POST`
2. Create a new validator
3. Add rules to validate the 3 fields
4. Validate `$_POST['comment']`

<br>

    if ( $_POST ) {
        $validator = new \Validator\Validator;
        $validator->addRule( new \Validator\Rule\MinLength( 2 ), 'name', 'Your name must be atleast 2 characters', 'Please enter your name' );
        $validator->addRule( new \Validator\Rule\Email, 'email', 'Please enter a valid email address' );
        $validator->addRule( new \Validator\Rule\MinLength( 2 ), 'text', 'Your comment must be atleast 2 characters', 'Please add a comment' );
        if ( !$validator->validate( $_POST['comment'] ) ) {
            $error = $validator->getFirstError();
        }
        else {
			// Add comment
        }
    }
---

##Filtering

    $validator->addFilter( $filter, $key = null )

You can filter globally or on a key basis. If `$key` is null then the filter is applied globally. `$filter` can be any [callable](http://php.net/manual/en/language.types.callable.php).


    $validator->addFilter( function( $v ){ return ltrim( $v ); } );
    $validator->addFilter( 'trim', 'email' );

---
##Errors

`getErrors()` will return an array of all the errors indexed by the key they were used for. Using our comment form example it might look like this:

	Array
	(
	    [name] => Array
	        (
	            [0] => Your name must be atleast 2 characters
	        )
	
	    [email] => Array
	        (
	            [0] => Please enter a valid email address
	        )
	
	    [text] => Array
	        (
	            [0] => Your comment must be atleast 2 characters
	        )
	)

`getFirstError()` will return the message for the first error encountered.

###Default empty error

Instead of adding the same "This is a required field" to every rule, you can add a default empty error that will be set anytime empty data is passed.

    $validator->enableDefaultEmptyError( $error_msg )

---

##Validator data

`getData()` will return the data that was passed for validation after the filters have been applied.

`getUnfilteredData()` will return the data that was passed for validation before the filters have been applied.
