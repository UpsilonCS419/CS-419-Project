document.getElementById("nav01").innerHTML =
"<ul id='menu'>" +
"<li id='admins'><a href='admins.php'>Admins</a></li>" +
"<li id='users'><a href='users.php'>Users</a></li>" +
"<li id='graph'><a href=''>Business Intelligence</a></li>" +
"</ul>";

var currentPage = window.location.href;
if (currentPage.match("users"))
{
    document.getElementById("users").style.fontWeight = "bold";
}
else if (currentPage.match("admins"))
{
    document.getElementById("admins").style.fontWeight = "bold";
}
