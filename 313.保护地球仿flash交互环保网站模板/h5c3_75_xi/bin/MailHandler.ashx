<%@ WebHandler Language="C#" Class="Handler" Debug="true" %>

using System;
using System.Web;
using System.Net.Mail;
using System.Text.RegularExpressions;

public class Handler : IHttpHandler {
	public void ProcessRequest (HttpContext context) {
		SmtpClient mailClient = new SmtpClient(context.Request.Form.Get("smtpMailServer"));
		string owner_email = context.Request.Form.Get("owner_email");
		string subject = "A message from your site visitor " + context.Request.Form.Get("name");
		string email = context.Request.Form.Get("email");
		string messageBody = "";
	
		messageBody += "<p>Visitor: " + context.Request.Form.Get("name") + "</p>\n";
		messageBody += "<br>\n";
		messageBody += "<p>Email Address: " + context.Request.Form.Get("email") + "</p>\n";
		messageBody += "<br>\n";
		messageBody += "<p>Phone Number: " + context.Request.Form.Get("phone") + "</p>\n";
		messageBody += "<br>\n";
		messageBody += "<p>Message: " + context.Request.Form.Get("message") + "</p>\n";
	
			
		MailMessage message = new MailMessage();
	
		try{
			message.From = new MailAddress(email.ToString());
		}catch (FormatException e) {
			context.Response.Write(e.Message);
		}
	
		message.To.Add(owner_email);
		message.Subject = subject;
		if(context.Request.Form.Get("stripHTML") == "true"){
			message.IsBodyHtml = false;
            messageBody = Regex.Replace(messageBody, "<.*?>", string.Empty);
		}else{
		  	message.IsBodyHtml = true;
		}
		message.Body = messageBody;
		
		try{
			mailClient.Send(message);
		}catch (SmtpException e) {
			context.Response.Write("mail failed");
		}
		context.Response.Write("mail sent");
	}

	public bool IsReusable {
		get	{
			return false;
		}
	}
}