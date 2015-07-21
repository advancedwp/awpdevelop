# WP-API SOCIAL LOGIN
We can do many awesome things with WP-API, when building [CodeCavalry](https://codecavalry.com) we needed a way to get people signed up logged in using social networks. While trying some existing plugins were not happy with the outcome and how the flow worked with our application. We created the start to a social login utilizing WP-API to more seamlessly integrate the login and registration.
  
This is v2 of our routes and plugin that includes a new table since some social API's don't respond with information you need to check if a user exists or create a user.
  
Supports [GitHub Updater](https://github.com/afragen/github-updater)
  
# API SETUP #
You will need to go to Settings > Social API to configure the API's you want to use. As of now we are only supporting _Facbeook_, _Twitter_, and _GitHub_.  
  
Do you want us to support more? Go to [hellojs](http://adodson.com/hello.js/) and create an issue in this GitHub repo with any supported social network and we will add it in.  
  
# USAGE #
Creation of 2 endpoints for __WP-API__  each accepts a data object array, make sure you are passing in an object named data:
  
`var data = { user_id: XXXXXXX, user_email: XXXX@YYY.com }`  
  
## LOGIN ENDPOINT
`/social_login` - use this to login an existing user, will do a check if user exists and return WP Error if no user found or insufficient data  
  
__Data Paramenters__  
* `social_id` from API - __required__
* `user_email` from API or injected by user - _optional_
  
## REGISTRATION ENDPOINT
_also handles login post register_  
`/social_registration` - us this to register and login a new user.  
  
__Data Parameneters__  
* `social_id` from API - __required__
* `user_email` from API or user - __required__
* `first_name` - _optional_
* `last_name` - _optional_
* `nickname` - or WP user nicename _optional_
* `description` - _optional_
  
  
# SHORTCODE #
Shortcode generates a form for your users -  
`[social_login]`  
  
__Shortcode Attributes__ 
* __nickname__ - `true/false` - include nickname field (_default: false_)
* __nickname_place_holder__ - `string` - placeholder for nickname field (_default: nickname_)
* __first_name__  - `true/false` - first name field (_default: false_)
* __first_name_placeholder__ - `string` - placeholder for the first name field (_default: First Name_)
* __last_name__  - `true/false` - last name field (_default: false_)
* __last_name_placeholder__ - `string` - placeholder for the last name field (_default: Last Name_)
* __submit_prefix__ - `string` - for submit buttons (_default: Login with_)
* __networks__ - `comma seperated string` - networks you want to offer (_default:facebook,twitter,github_)
* __social_action__ - `login/register` - used to identify if this is a login form or signup form (_default:login_)
* __redirect__ - `url` - redirect user after sign in or register (_default:current url_)
  
# FULL SHORTCODE EXAMPLE #
`[social_login nickname="true" nickname_placeholder="Custom Username" first_name="true" first_name_placeholder="First Name" last_name="true" last_name_placeholder="Last Name" submit_prefix="Register with" networks="facebook,twitter" social_action="register" redirect="/new-page"]`
