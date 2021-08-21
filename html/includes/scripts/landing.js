require(["fnforms"],function(fnforms){
	fnforms.formhash(form, password, password1);
	fnforms.formhashnew(form, password, password1);
	fnforms.formhashl(form, password);
});

require(["fnlogin"],function(fnlogin){
	fnlogin.ready();
});

require(["fnregister"],function(fnregister){
	fnregister.ready();
});

require(["fnregister_user"],function(fnregister_user){
	fnregister_user.ready();
	fnregister_user.check_username_availability();
});

require(["fnregister_mail"],function(fnregister_mail){
	fnregister_mail.ready();
	fnregister_mail.check_email_availability();
});

require(["fnsecurity"],function(fnsecurity){
	fnsecurity.ready();
});

require(["fnrc_reset"],function(fnrc_reset){
	fnrc_reset.ready();
});
