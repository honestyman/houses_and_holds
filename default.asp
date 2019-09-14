<%
EnableSessionState=False
host = Request.ServerVariables("HTTP_HOST")

if host = "housesandholds.com" or host = "www.housesandholds.com" then
response.redirect("https://www.housesandholds.com/")

else
response.redirect("https://www.housesandholds.com/error.htm")

end if
%>
