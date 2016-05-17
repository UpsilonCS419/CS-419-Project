document.getElementById("nav01").innerHTML =
"<ul id='menu'>" +
"<li id='users'><a href='usersonly.php'>My Account Settings</a></li>" +
"<li id='awards'><a href='businessuser.php'>Award Center</a></li>" +
"</ul>";

var currentPage = window.location.href;
if (currentPage.match("users"))
{
    document.getElementById("users").style.fontWeight = "bold";
}
else if (currentPage.match("awards"))
{
    document.getElementById("awards").style.fontWeight = "bold";
}
