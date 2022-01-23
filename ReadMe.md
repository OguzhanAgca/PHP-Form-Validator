## PHP Simple Form Validation

You can do a simple form control in PHP!

### Usage

- Create a new object from FormValidation class.
- Check form using chaining methods.

### Code Template

```php
$formVal = new FormValidation();
$formVal->name("PlaceholderName")->value(FormValue)->validation("name || lastname || username || email || password")->required();
$formVal->name("PlaceholderName")->value(FormValue)->customValidation("/pattern/","message")-required();
$formVal->name("PlaceholderName")->fileValidation(FileName,FileSize,AllowedSize,AllowedExt)->required();
```

### Code Example

For example, I have a form with username, name, last name, email, password, and image fields.
And I pass the data from the user through the security functions and store it in variables like below.

```php
$userName = $_POST["username"];
$name = $_POST["name"];
$lastName = $_POST["lastname"];
$email = $_POST["email"];
$password = $_POST["password"];
$file = $_FILES["myFile"];
```

Now, we can create an object from the FormValidation class as below and check the incoming data and print information to the user.

```php
$formVal = new FormValidation();
$formVal->name("Username")->value($userName)->validation("username")->required();
$formVal->name("Name")->value($name)->validation("name")->required();
$formVal->name("Lastname")->value($lastName)->validation("lastname")->required();
$formVal->name("E-mail")->value($email)->validation("email")->required();
$formVal->name("Password")->value($password)->validation("password")->required();
$formVal->name("Image")->>fileValidation($file["name"],$file["size"],1048576,["png","jpg"]);
```

If we want to do different control, we can use the customValidation() method in the FormValidation class.

```php
$formVal->name("Address")->value($address)->customValidation("/pattern/", "Your address is wrong..")->required();
```

After making our form control, we can simply inform the user.

```php
if($formVal->isSuccess() === true){
    echo "Form check successful";
    .
    .
}else{
    echo $formVal->isSuccess()["Name"];
    echo $formVal->isSuccess()["E-mail"];
    .
    .
    .
}
```
