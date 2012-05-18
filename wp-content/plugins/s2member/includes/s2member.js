/*
Copyright: © 2009 WebSharks, Inc. ( coded in the USA )
<mailto:support@websharks-inc.com> <http://www.websharks-inc.com/>

Released under the terms of the GNU General Public License.
You should have received a copy of the GNU General Public License,
along with this software. In the main directory, see: /licensing/
If not, see: <http://www.gnu.org/licenses/>.
*/
/*
Scripting routines handled on document ready state.
*/
jQuery (document).ready (function($)
	{
		ws_plugin__s2member_uniqueFilesDownloaded = []; /* Real-time counts. */
		/* This is used in case a user downloads multiple files from a single page. */
		/**/
		if (S2MEMBER_CURRENT_USER_IS_LOGGED_IN && S2MEMBER_CURRENT_USER_DOWNLOADS_CURRENTLY < S2MEMBER_CURRENT_USER_DOWNLOADS_ALLOWED)
			{
				$ ('a[href*="s2member_file_download"]').click (function()
					{
						if (!this.href.match (/s2member_file_download_key\=(.+)/i))
							{
								var c = '** Please Confirm This File Download **\n\n';
								c += 'You\'ve downloaded ' + S2MEMBER_CURRENT_USER_DOWNLOADS_CURRENTLY + ' protected file' + ((S2MEMBER_CURRENT_USER_DOWNLOADS_CURRENTLY < 1 || S2MEMBER_CURRENT_USER_DOWNLOADS_CURRENTLY > 1) ? 's' : '') + ' in the last ' + S2MEMBER_CURRENT_USER_DOWNLOADS_ALLOWED_DAYS + ' days.\n\n';
								c += 'You\'re entitled to ' + ((S2MEMBER_CURRENT_USER_DOWNLOADS_ALLOWED_IS_UNLIMITED) ? 'UNLIMITED downloads though ( so, no worries ).' : S2MEMBER_CURRENT_USER_DOWNLOADS_ALLOWED + ' unique downloads every ' + S2MEMBER_CURRENT_USER_DOWNLOADS_ALLOWED_DAYS + ' day period.');
								/**/
								if (this.href.match (/s2member_skip_confirmation/i) || confirm (c))
									{
										if ($.inArray (this.href, ws_plugin__s2member_uniqueFilesDownloaded) === -1) /* Real-time counting. */
											ws_plugin__s2member_uniqueFilesDownloaded.push (this.href), S2MEMBER_CURRENT_USER_DOWNLOADS_CURRENTLY++;
										return true; /* Allow. */
									}
								else /* Disallow. */
									return false;
							}
						else /* Allow. */
							return true;
					});
			}
		/*
		Attach form submission handler to wp-signup.php.
		*/
		if (location.href.match (/\/wp-signup\.php/))
			/**/
			$ ('div#content > div.mu_register > form#setupform').submit (function()
				{
					var context = this, label = '', error = '', errors = '';
					/**/
					$ ('input#user_name, input#user_email, input#blogname, input#blog_title', context).each (function()
						{
							if ((label = $.trim ($ (this).prev ('label').text ().replace (/[\r\n\t]+/g, ' '))))
								{
									if (error = ws_plugin__s2member_validationErrors (label, this, context, true))
										errors += error + '\n\n'; /* Collect errors. */
								}
							/**/
							else if ((label = $.trim ($ (this).prev ('span.prefix_address').prev ('label').text ().replace (/[\r\n\t]+/g, ' '))))
								{
									if (error = ws_plugin__s2member_validationErrors (label, this, context, true))
										errors += error + '\n\n'; /* Collect errors. */
								}
						});
					/**/
					$ (':input', context).each (function()
						{
							if ((label = $.trim ($ (this).prev ('label').text ().replace (/[\r\n\t]+/g, ' '))))
								if (error = ws_plugin__s2member_validationErrors (label, this, context))
									errors += error + '\n\n'; /* Collect errors. */
						});
					/**/
					if (errors = $.trim (errors))
						{
							alert ('Oops, you missed something:\n\n' + errors);
							return false;
						}
					/**/
					return true;
				});
		/*
		Attach form submission handler to wp-login.php?action=register.
		*/
		else if (location.href.match (/\/wp-login\.php/))
			/**/
			$ ('div#login > form#registerform').submit (function()
				{
					var context = this, label = '', error = '', errors = '';
					/**/
					$ ('input#user_login, input#user_email', context).each (function()
						{
							if ((label = $.trim ($ (this).parent ('label').text ().replace (/[\r\n\t]+/g, ' '))))
								if (error = ws_plugin__s2member_validationErrors (label, this, context, true))
									errors += error + '\n\n'; /* Collect errors. */
						});
					/**/
					$ (':input', context).each (function()
						{
							if ((label = $.trim ($ (this).parent ('label').children ('span').slice (0, 1).text ().replace (/[\r\n\t]+/g, ' '))))
								if (error = ws_plugin__s2member_validationErrors (label, this, context))
									errors += error + '\n\n'; /* Collect errors. */
						});
					/**/
					if (errors = $.trim (errors))
						{
							alert ('Oops, you missed something:\n\n' + errors);
							return false;
						}
					/**/
					return true;
				});
		/*
		Attach form submission handler to ?s2member_profile=1.
		*/
		else if (location.href.match (/\/\?s2member_profile\=1/))
			/**/
			$ ('form#ws-plugin--s2member-profile').submit (function()
				{
					var context = this, label = '', error = '', errors = '';
					/**/
					var $password = $ ('input#ws-plugin--s2member-profile-password');
					var $passwordConfirmation = $ ('input#ws-plugin--s2member-profile-password-confirmation');
					/**/
					$ (':input', context).each (function()
						{
							if ((label = $.trim ($ (this).parent ('label').children ('strong').slice (0, 1).text ().replace (/[\r\n\t]+/g, ' '))))
								if (error = ws_plugin__s2member_validationErrors (label, this, context))
									errors += error + '\n\n'; /* Collect errors. */
						});
					/**/
					if (errors = $.trim (errors))
						{
							alert ('Oops, you missed something:\n\n' + errors);
							return false;
						}
					/**/
					else if ($.trim ($password.val ()) && $.trim ($password.val ()) !== $.trim ($passwordConfirmation.val ()))
						{
							alert ('Oops, you missed something:\n\nPasswords do not match up. Please try again.');
							return false;
						}
					/**/
					return true;
				});
		/*
		Attach form submission handler to profile.php.
		*/
		else if (location.href.match (/\/wp-admin\/profile\.php/))
			/**/
			$ ('form#your-profile').submit (function() /* Validation. */
				{
					var context = this, label = '', error = '', errors = '';
					/**/
					$ (':input[id^="ws-plugin--s2member-profile-"]', context).each (function()
						{
							if ((label = $.trim ($ (this).parent ('td').prev ('th').children ('label').slice (0, 1).text ().replace (/[\r\n\t]+/g, ' '))))
								if (error = ws_plugin__s2member_validationErrors (label, this, context))
									errors += error + '\n\n'; /* Collect errors. */
						});
					/**/
					if (errors = $.trim (errors))
						{
							alert ('Oops, you missed something:\n\n' + errors);
							return false;
						}
					/**/
					return true;
				});
		/*
		Global function handles validation errors.
		*/
		ws_plugin__s2member_validationErrors = function(label, field, context, required, expected)
			{
				if (typeof label === 'string' && label && typeof field === 'object' && typeof context === 'object')
					if (typeof field.tagName === 'string' && field.tagName.match (/^(input|textarea|select)$/i))
						{
							var tag = field.tagName.toLowerCase (), $field = $ (field), type = String ($field.attr ('type')).toLowerCase (), name = String ($field.attr ('name')), value = $field.val ();
							var required = ( typeof required === 'boolean') ? required : ($field.attr ('aria-required') === 'true'), expected = ( typeof expected === 'string') ? expected : $field.attr ('data-expected');
							/**/
							if (tag === 'input' && type === 'checkbox' && name.match (/\[\]$/))
								{
									if (typeof field.id === 'string' && field.id.match (/-0$/)) /* First one only. */
										if (required && !$ ('input[name="' + name.replace (/([\[\]])/g, '\$1') + '"]:checked', context).length)
											return label + '\nPlease check at least one of the boxes.';
								}
							else if (tag === 'input' && type === 'checkbox')
								{
									if (required && !field.checked) /* Check required? */
										return label + '\nRequired. This box must be checked.';
								}
							else if (tag === 'input' && type === 'radio')
								{
									if (typeof field.id === 'string' && field.id.match (/-0$/)) /* First one only. */
										if (required && !$ ('input[name="' + name.replace (/([\[\]])/g, '\$1') + '"]:checked', context).length)
											return label + '\nPlease select one of the options.';
								}
							else if (tag === 'select' && $field.attr ('multiple'))
								{
									if (required && (!(value instanceof Array) || !value.length))
										return label + '\nPlease select at least one of the options.';
								}
							else if (typeof value !== 'string' || (required && !(value = $.trim (value)).length))
								/* If we get here, the value MUST be in string format, and we need to trim the string before validation. */
								{
									return label + '\nThis is a required field, please try again.'; /* Missing data. */
								}
							else if ((value = $.trim (value)).length && ((tag === 'input' && type.match (/^(text|password)$/i)) || tag === 'textarea') && typeof expected === 'string' && expected.length)
								{
									if (expected === 'numeric-wp-commas' && (!value.match (/^[0-9\.,]+$/) || isNaN (value.replace (/,/g, ''))))
										{
											return label + '\nMust be numeric ( with or without decimals, commas allowed ).';
										}
									else if (expected === 'numeric' && (!value.match (/^[0-9\.]+$/) || isNaN (value)))
										{
											return label + '\nMust be numeric ( with or without decimals, no commas ).';
										}
									else if (expected === 'integer' && (!value.match (/^[0-9]+$/) || isNaN (value)))
										{
											return label + '\nMust be an integer ( a whole number, without any decimals ).';
										}
									else if (expected === 'integer-gt-0' && (!value.match (/^[0-9]+$/) || isNaN (value) || value <= 0))
										{
											return label + '\nMust be an integer > 0 ( whole number, no decimals, greater than 0 ).';
										}
									else if (expected === 'float' && (!value.match (/^[0-9\.]+$/) || !value.match (/[0-9]/) || !value.match (/\./) || isNaN (value)))
										{
											return label + '\nMust be a float ( floating point number, decimals required ).';
										}
									else if (expected === 'float-gt-0' && (!value.match (/^[0-9\.]+$/) || !value.match (/[0-9]/) || !value.match (/\./) || isNaN (value) || value <= 0))
										{
											return label + '\nMust be a float > 0 ( floating point number, decimals required, greater than 0 ).';
										}
									else if (expected === 'date' && !value.match (/^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/))
										{
											return label + '\nMust be a date ( required date format: dd/mm/yyyy ).';
										}
									else if (expected === 'email' && !value.match (/^([a-z_~0-9\+\-]+)(((\.?)([a-z_~0-9\+\-]+))*)(@)([a-z0-9]+)(((-*)([a-z0-9]+))*)(((\.)([a-z0-9]+)(((-*)([a-z0-9]+))*))*)(\.)([a-z]{2,6})$/i))
										{
											return label + '\nMust be a valid email address.';
										}
									else if (expected === 'url' && !value.match (/^http(s?)\:\/\/(.{5,})$/i))
										{
											return label + '\nMust be a full URL ( starting with http or https ).';
										}
									else if (expected === 'domain' && !value.match (/^([a-z0-9]+)(((-*)([a-z0-9]+))*)(((\.)([a-z0-9]+)(((-*)([a-z0-9]+))*))*)(\.)([a-z]{2,6})$/i))
										{
											return label + '\nMust be a domain name ( domain name only, without http ).';
										}
									else if (expected === 'phone' && (!value.match (/^[0-9 \(\)\-]+$/) || value.replace (/[^0-9]/g, '').length !== 10))
										{
											return label + '\nMust be a phone # ( 10 digits w/possible hyphens,spaces,brackets ).';
										}
									else if (expected === 'uszip' && !value.match (/^[0-9]{5}(-[0-9]{4})?$/))
										{
											return label + '\nMust be a US zipcode ( 5-9 digits w/possible hyphen ).';
										}
									else if (expected === 'cazip' && !value.match (/^[0-9A-Z]{3}( ?)[0-9A-Z]{3}$/i))
										{
											return label + '\nMust be a Canadian zipcode ( 6 alpha-numerics w/possible space ).';
										}
									else if (expected === 'uczip' && !value.match (/^[0-9]{5}(-[0-9]{4})?$/) && !value.match (/^[0-9A-Z]{3}( ?)[0-9A-Z]{3}$/i))
										{
											return label + '\nMust be a zipcode ( either a US or Canadian zipcode ).';
										}
									else if (expected.match (/^alphanumerics-spaces-punctuation-([0-9]+)(-e)?$/) && !value.match (/^[a-z 0-9,\.\/\?\:;"'\{\}\[\]\|\\\+\=_\-\(\)\*&\^%\$#@\!`~]+$/i))
										{
											return label + '\nPlease use alphanumerics, spaces & punctuation only.';
										}
									else if (expected.match (/^alphanumerics-spaces-([0-9]+)(-e)?$/) && !value.match (/^[a-z 0-9]+$/i))
										{
											return label + '\nPlease use alphanumerics & spaces only.';
										}
									else if (expected.match (/^alphanumerics-punctuation-([0-9]+)(-e)?$/) && !value.match (/^[a-z0-9,\.\/\?\:;"'\{\}\[\]\|\\\+\=_\-\(\)\*&\^%\$#@\!`~]+$/i))
										{
											return label + '\nPlease use alphanumerics & punctuation only ( no spaces ).';
										}
									else if (expected.match (/^alphanumerics-([0-9]+)(-e)?$/) && !value.match (/^[a-z0-9]+$/i))
										{
											return label + '\nPlease use alphanumerics only ( no spaces/punctuation ).';
										}
									else if (expected.match (/^alphabetics-([0-9]+)(-e)?$/) && !value.match (/^[a-z]+$/i))
										{
											return label + '\nPlease use alphabetics only ( no digits/spaces/punctuation ).';
										}
									else if (expected.match (/^numerics-([0-9]+)(-e)?$/) && !value.match (/^[0-9]+$/i))
										{
											return label + '\nPlease use numeric digits only.';
										}
									else if (expected.match (/^(any|alphanumerics-spaces-punctuation|alphanumerics-spaces|alphanumerics-punctuation|alphanumerics|alphabetics|numerics)-([0-9]+)(-e)?$/))
										{
											var split = expected.split ('-'), length = Number (split[1]), exactLength = (split.length > 2) ? Number (split[2]) : '';
											/**/
											if (exactLength && value.length !== length) /* An exact length is required? */
												return label + '\nMust be exactly ' + length + ' ' + ((split[0] === 'numerics') ? 'digit' : 'character') + ((length > 1) ? 's' : '') + '.';
											/**/
											else if (value.length < length) /* Otherwise, we interpret as the minimum length. */
												return label + '\nMust be at least ' + length + ' ' + ((split[0] === 'numerics') ? 'digit' : 'character') + ((length > 1) ? 's' : '') + '.';
										}
								}
						}
				/**/
				return '';
			};
	});