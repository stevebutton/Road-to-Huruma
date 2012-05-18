/*
Copyright: © 2009 WebSharks, Inc. ( coded in the USA )
<mailto:support@websharks-inc.com> <http://www.websharks-inc.com/>

Released under the terms of the GNU General Public License.
You should have received a copy of the GNU General Public License,
along with this software. In the main directory, see: /licensing/
If not, see: <http://www.gnu.org/licenses/>.
*/
/*
These routines are all specific to this software.
*/
jQuery (document).ready (function($)
	{
		var esc_attr = esc_html = function(str) /* Convert special characters. */
			{
				return String (str).replace (/"/g, '&quot;').replace (/\</g, '&lt;').replace (/\>/g, '&gt;');
			};
		/**/
		if (location.href.match (/page\=ws-plugin--s2member-mms-options/))
			{
				$ ('select#ws-plugin--s2member-mms-registration-file').change (function()
					{
						if ($ (this).val () === 'wp-signup') /* Expand/collapse relevant options; based on file selection. */
							{
								$ ('div#ws-plugin--s2member-mms-registration-support-package-details-wrapper').show (), $ ('div.ws-plugin--s2member-mms-registration-wp-login, table.ws-plugin--s2member-mms-registration-wp-login').hide (), $ ('div.ws-plugin--s2member-mms-registration-wp-signup, table.ws-plugin--s2member-mms-registration-wp-signup').show ();
							}
						else if ($ (this).val () === 'wp-login') /* Expand/collapse relevant options. */
							{
								$ ('div#ws-plugin--s2member-mms-registration-support-package-details-wrapper').hide (), $ ('div.ws-plugin--s2member-mms-registration-wp-login, table.ws-plugin--s2member-mms-registration-wp-login').show (), $ ('div.ws-plugin--s2member-mms-registration-wp-signup, table.ws-plugin--s2member-mms-registration-wp-signup').hide ();
							}
						/**/
						$ ('div.ws-plugin--s2member-mms-registration-wp-signup-blogs-level0, table.ws-plugin--s2member-mms-registration-wp-signup-blogs-level0')[ ( ($ ('select#ws-plugin--s2member-mms-registration-grants').val () === 'all') ? 'show' : 'hide')] (), $ ('input#ws-plugin--s2member-mms-registration-blogs-level0').val ( ( ($ ('select#ws-plugin--s2member-mms-registration-grants').val () === 'all') ? '1' : '0'));
					/**/
					}).trigger ('change'); /* Fire on ready too. */
				/**/
				$ ('select#ws-plugin--s2member-mms-registration-grants').change (function()
					{
						$ ('select#ws-plugin--s2member-mms-registration-file').trigger ('change');
					});
			}
		/**/
		else if (location.href.match (/page\=ws-plugin--s2member-options/))
			{
				ws_plugin__s2member_generateSecurityKey = function() /* Generates a unique Security Key. */
					{
						var mt_rand = function(min, max) /* The PHP equivalent to mt_rand(). */
							{
								min = (arguments.length < 1) ? 0 : min;
								max = (arguments.length < 2) ? 2147483647 : max;
								/**/
								return Math.floor (Math.random () * (max - min + 1)) + min;
							};
						/**/
						var chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()';
						for (var i = 0, key = ''; i < 56; i++) key += chars.substr (mt_rand (0, chars.length - 1), 1);
						/**/
						$ ('input#ws-plugin--s2member-sec-encryption-key').val (key);
						/**/
						return false;
					};
				/**/
				ws_plugin__s2member_enableSecurityKey = function() /* Allow Security Key editing?? */
					{
						if (confirm ('Edit Key? Are you sure?\nThis could break your installation!\n\n*Note* If you\'ve been testing s2Member, feel free to change this Key before you go live. Just don\'t go live, and then change it. You\'ll have some very unhappy Customers. Data corruption WILL occur!\n\nFor your safety, s2Member keeps a history of the last 10 Keys that you\'ve used. If you get yourself into a real situation, s2Member will let you revert back to a previous Key.'))
							$ ('input#ws-plugin--s2member-sec-encryption-key').attr ('disabled', false);
						/**/
						return false;
					};
				/**/
				ws_plugin__s2member_securityKeyHistory = function() /* Displays history of Keys. */
					{
						$ ('div#ws-plugin--s2member-sec-encryption-key-history').toggle ();
						/**/
						return false;
					};
				/**/
				if ($ ('input#ws-plugin--s2member-custom-reg-fields').length && $ ('div#ws-plugin--s2member-custom-reg-field-configuration').length)
					{
						(function() /* Wrap these routines inside a function to keep variables within relative scope. */
							{
								var $fields = $ ('input#ws-plugin--s2member-custom-reg-fields');
								var $configuration = $ ('div#ws-plugin--s2member-custom-reg-field-configuration');
								var fields = ($fields.val ()) ? $.JSON.parse ($fields.val ()) : []; /* Parse. */
								fields = (fields instanceof Array) ? fields : []; /* Force array. */
								/**/
								var tools = '<div id="ws-plugin--s2member-custom-reg-field-configuration-tools"></div>';
								var table = '<table id="ws-plugin--s2member-custom-reg-field-configuration-table"></table>';
								/**/
								$configuration.html (tools + table); /* Add tools and table to configuration. */
								/**/
								var $tools = $ ('div#ws-plugin--s2member-custom-reg-field-configuration-tools');
								var $table = $ ('table#ws-plugin--s2member-custom-reg-field-configuration-table');
								/**/
								ws_plugin__s2member_customRegFieldTypeChange = function(select)
									{
										var tr1, tr2, type = $ (select).val (); /* Current selection. */
										/**/
										tr1 = 'tr.ws-plugin--s2member-custom-reg-field-configuration-tools-form-options';
										tr2 = 'tr.ws-plugin--s2member-custom-reg-field-configuration-tools-form-expected';
										/**/
										if (type.match (/^(text|textarea|checkbox|pre_checkbox)$/))
											$ (tr1).css ('display', 'none'), $ (tr1).prev ('tr').css ('display', 'none');
										else /* Otherwise we display the table row by removing the display property. */
											$ (tr1).css ('display', ''), $ (tr1).prev ('tr').css ('display', '');
										/**/
										/**/
										if (type.match (/^(select|selects|checkboxes|radios)$/))
											$ (tr2).css ('display', 'none'), $ (tr2).prev ('tr').css ('display', 'none');
										else /* Otherwise we display the table row by removing the display property. */
											$ (tr2).css ('display', ''), $ (tr2).prev ('tr').css ('display', '');
									};
								/**/
								ws_plugin__s2member_customRegFieldDelete = function(index)
									{
										var newFields = new Array (); /* Build array. */
										/**/
										for (var i = 0; i < fields.length; i++)
											if (i !== index) /* Omit index. */
												newFields.push (fields[i]);
										/**/
										fields = newFields, updateFields (), buildTable ();
									};
								/**/
								ws_plugin__s2member_customRegFieldMoveUp = function(index)
									{
										if (typeof fields[index] === 'object' && typeof fields[index - 1] === 'object')
											{
												var prevFieldObj = fields[index - 1], thisFieldObj = fields[index];
												/**/
												fields[index - 1] = thisFieldObj, fields[index] = prevFieldObj;
												/**/
												updateFields (), buildTable ();
											}
									};
								/**/
								ws_plugin__s2member_customRegFieldMoveDown = function(index)
									{
										if (typeof fields[index] === 'object' && typeof fields[index + 1] === 'object')
											{
												var nextFieldObj = fields[index + 1], thisFieldObj = fields[index];
												/**/
												fields[index + 1] = thisFieldObj, fields[index] = nextFieldObj;
												/**/
												updateFields (), buildTable ();
											}
									};
								/**/
								ws_plugin__s2member_customRegFieldCreate = function()
									{
										var $table = $ ('table#ws-plugin--s2member-custom-reg-field-configuration-tools-form'), field = {};
										/**/
										$ (':input[property]', $table).each (function() /* Go through each property value. */
											{
												var $this = $ (this), property = $this.attr ('property'), val = $.trim ($this.val ());
												/**/
												field[property] = val;
											});
										/**/
										if ((field = validateField (field))) /* If it can be validated. */
											{
												fields.push (field), updateFields (), buildTools (), buildTable (), scrollReset ();
												/**/
												setTimeout (function() /* A momentary delay here for usability. */
													{
														var row = 'tr.ws-plugin--s2member-custom-reg-field-configuration-table-row-' + (fields.length - 1);
														alert ('Field created successfully.\n* Remember to "Save Changes".');
														$ (row).effect ('highlight', 1000);
													}, 500);
											}
									};
								/**/
								ws_plugin__s2member_customRegFieldUpdate = function(index)
									{
										var $table = $ ('table#ws-plugin--s2member-custom-reg-field-configuration-tools-form'), field = {};
										/**/
										$ (':input[property]', $table).each (function() /* Go through each property value. */
											{
												var $this = $ (this), property = $this.attr ('property'), val = $.trim ($this.val ());
												/**/
												field[property] = val;
											});
										/**/
										if ((field = validateField (field, index))) /* If it validates. */
											{
												fields[index] = field, updateFields (), buildTools (), buildTable (), scrollReset ();
												/**/
												var row = 'tr.ws-plugin--s2member-custom-reg-field-configuration-table-row-' + index;
												$ (row).effect ('highlight', 1000);
											}
									};
								/**/
								ws_plugin__s2member_customRegFieldAdd = function() /* Add new field links. */
									{
										buildTools (true); /* No need to reset scroll position. */
									};
								/**/
								ws_plugin__s2member_customRegFieldEdit = function(index) /* Edit links. */
									{
										buildTools (false, index), scrollReset (); /* Reset scroll position. */
									};
								/**/
								ws_plugin__s2member_customRegFieldCancel = function() /* Cancel form. */
									{
										buildTools (), scrollReset (); /* Re-build without the form. */
									};
								/**/
								var validateField = function(field, index)
									{
										var editing = ( typeof index === 'number' && typeof fields[index] === 'object') ? true : false, errors = [], options, i;
										/**/
										if (typeof field !== 'object') /* Must be an object. */
											{
												errors.push ('Invalid field object. Please try again.');
											}
										else /* We only proceed with these other checks if field is an object. */
											{
												if (!field.id)
													{
														errors.push ('Unique Field ID:\nThis is required. Please try again.');
													}
												else if (fieldIdExists (field.id) && (!editing || field.id !== fields[index].id))
													{
														errors.push ('Unique Field ID:\nThat Field ID already exists. Please try again.');
													}
												/**/
												if (!field.label)
													{
														errors.push ('Field Label/Description:\nThis is required. Please try again.');
													}
												/**/
												if (field.type.match (/^(select|selects|checkboxes|radios)$/))
													{
														field.expected = ''; /* Empty this ( n/a ). */
														/**/
														if (!field.options)
															{
																errors.push ('Option Configuration File:\nThis is required. Please try again.');
															}
														else /* Otherwise, we need to go through each lineof the option configuration. */
															{
																options = field.options.split (/[\r\n]+/);
																/**/
																for (i = 0; i < options.length; i++)
																	{
																		options[i] = $.trim (options[i]);
																		/**/
																		if (!options[i].match (/^([^\|]*)(\|)([^\|]*)(\|default)?$/))
																			{
																				errors.push ('Option Configuration File:\nInvalid configuration at line #' + (i + 1) + '.');
																				break; /* Break now. There could potentially be lots of lines with errors like this. */
																			}
																	}
																/**/
																field.options = $.trim (options.join ('\n')); /* Cleaned. */
															}
													}
												else /* Else there should NOT be any options associated with this type. */
													{
														field.options = ''; /* Force empty options. */
													}
												/**/
												if (! (field.levels = field.levels.replace (/ /g, '')))
													{
														errors.push ('Applicable Levels:\nThis is required. Please try again.');
													}
												else if (!field.levels.match (/^(all|[0-9,]+)$/))
													{
														errors.push ('Applicable Levels:\nShould be comma delimited Levels, or just type: all.\n( examples: 0,1,2,3,4 or type the word: all )');
													}
												/**/
												if (field.classes && field.classes.match (/[^a-z 0-9 _ \-]/i))
													{
														errors.push ('CSS Classes:\nContains invalid characters. Please try again.\n( only: alphanumerics, underscores, hyphens, spaces )');
													}
												/**/
												if (field.styles && field.styles.match (/["\=\>\<]/))
													{
														errors.push ('CSS Styles:\nContains invalid characters. Please try again.\n( do NOT use these characters: = " < > )');
													}
												/**/
												if (field.attrs && field.attrs.match (/[\>\<]/))
													{
														errors.push ('Other Attributes:\nContains invalid characters. Please try again.\n( do NOT use these characters: < > )');
													}
											}
										/**/
										if (errors.length > 0) /* Errors? */
											{
												alert (errors.join ('\n\n'));
												return false;
											}
										else /* Return. */
											return field;
									};
								/**/
								var updateFields = function() /* Update hidden input value. */
									{
										$fields.val ( ( (fields.length > 0) ? $.JSON.stringify (fields) : ''));
									};
								/**/
								var fieldId2Var = function(fieldId) /* Convert ids to variables. */
									{
										return ( typeof fieldId === 'string') ? $.trim (fieldId).toLowerCase ().replace (/[^a-z0-9]/g, '_') : '';
									};
								/**/
								var fieldTypeDesc = function(type)
									{
										var types = {text: 'Text ( single line )', textarea: 'Textarea ( multi-line )', select: 'Select Menu ( drop-down )', selects: 'Select Menu ( multi-option )', checkbox: 'Checkbox ( single )', pre_checkbox: 'Checkbox ( pre-checked )', checkboxes: 'Checkboxes ( multi-option )', radios: 'Radio Buttons ( multi-option )'};
										/**/
										if (typeof types[type] === 'string')
											return types[type];
										/**/
										return ''; /* Default. */
									};
								/**/
								var fieldIdExists = function(fieldId) /* Already exists? */
									{
										for (var i = 0; i < fields.length; i++)
											if (fields[i].id === fieldId)
												return true;
									};
								/**/
								var scrollReset = function() /* Return to Custom Fields section. */
									{
										scrollTo (0, $ ('div.ws-plugin--s2member-custom-reg-fields-section').offset ()['top'] - 100);
									};
								/**/
								var buildTools = function(adding, index) /* This builds tools into the configuration. */
									{
										var i = 0, html = '', form = '', w = 0, h = 0, defaults = {id: '', label: '', type: 'text', options: '', expected: '', required: 'yes', levels: 'all', editable: 'yes', classes: '', styles: '', attrs: ''};
										var editing = ( typeof index === 'number' && typeof fields[index] === 'object') ? true : false, displayForm = (adding || editing) ? true : false, field = (editing) ? fields[index] : defaults;
										/**/
										html += '<a href="#" onclick="ws_plugin__s2member_customRegFieldAdd(); return false;">Add New Field</a>'; /* Click to add a new Custom Registration Field. */
										/**/
										tb_remove (), $ ('div#ws-plugin--s2member-custom-reg-field-configuration-thickbox-tools-form').remove (); /* Remove an existing thickbox. */
										/**/
										if (displayForm) /* Do we need to display the adding/editing form at all?
										*NOTE* This is NOT an actual <form>, because we're already inside another form tag. */
											{
												form += '<div id="ws-plugin--s2member-custom-reg-field-configuration-thickbox-tools-form">';
												/**/
												form += '<table id="ws-plugin--s2member-custom-reg-field-configuration-tools-form">';
												form += '<tbody>';
												/**/
												form += '<tr class="ws-plugin--s2member-custom-reg-field-configuration-tools-form-type">';
												form += '<td colspan="2">';
												form += '<label for="ws-plugin--s2member-custom-reg-field-configuration-tools-form-type">Form Field Type: *</label>';
												form += '</td>';
												form += '</tr>';
												/**/
												form += '<tr class="ws-plugin--s2member-custom-reg-field-configuration-tools-form-type">';
												form += '<td colspan="2">';
												form += '<select property="type" onchange="ws_plugin__s2member_customRegFieldTypeChange(this);" id="ws-plugin--s2member-custom-reg-field-configuration-tools-form-type">';
												form += '<option value="text"' + ( (field.type === 'text') ? ' selected="selected"' : '') + '">' + esc_html (fieldTypeDesc ('text')) + '</option>';
												form += '<option value="textarea"' + ( (field.type === 'textarea') ? ' selected="selected"' : '') + '">' + esc_html (fieldTypeDesc ('textarea')) + '</option>';
												form += '<option value="select"' + ( (field.type === 'select') ? ' selected="selected"' : '') + '">' + esc_html (fieldTypeDesc ('select')) + '</option>';
												form += '<option value="selects"' + ( (field.type === 'selects') ? ' selected="selected"' : '') + '">' + esc_html (fieldTypeDesc ('selects')) + '</option>';
												form += '<option value="checkbox"' + ( (field.type === 'checkbox') ? ' selected="selected"' : '') + '">' + esc_html (fieldTypeDesc ('checkbox')) + '</option>';
												form += '<option value="pre_checkbox"' + ( (field.type === 'pre_checkbox') ? ' selected="selected"' : '') + '">' + esc_html (fieldTypeDesc ('pre_checkbox')) + '</option>';
												form += '<option value="checkboxes"' + ( (field.type === 'checkboxes') ? ' selected="selected"' : '') + '">' + esc_html (fieldTypeDesc ('checkboxes')) + '</option>';
												form += '<option value="radios"' + ( (field.type === 'radios') ? ' selected="selected"' : '') + '">' + esc_html (fieldTypeDesc ('radios')) + '</option>';
												form += '</select>';
												form += '</td>';
												form += '</tr>';
												/**/
												form += '<tr class="ws-plugin--s2member-custom-reg-field-configuration-tools-form-spacer"><td colspan="2">&nbsp;</td></tr>';
												/**/
												form += '<tr class="ws-plugin--s2member-custom-reg-field-configuration-tools-form-label">';
												form += '<td colspan="2">';
												form += '<label for="ws-plugin--s2member-custom-reg-field-configuration-tools-form-label">Field Label/Desc: *</label>';
												form += '</td>';
												form += '</tr>';
												/**/
												form += '<tr class="ws-plugin--s2member-custom-reg-field-configuration-tools-form-label">';
												form += '<td colspan="2">';
												form += '<input type="text" property="label" value="' + esc_attr (field.label) + '" id="ws-plugin--s2member-custom-reg-field-configuration-tools-form-label" /><br />';
												form += '<small>Examples: <code>Choose Country</code>, <code>Street Address</code></small>';
												form += '</td>';
												form += '</tr>';
												/**/
												form += '<tr class="ws-plugin--s2member-custom-reg-field-configuration-tools-form-spacer"><td colspan="2">&nbsp;</td></tr>';
												/**/
												form += '<tr class="ws-plugin--s2member-custom-reg-field-configuration-tools-form-id">';
												form += '<td colspan="2">';
												form += '<label for="ws-plugin--s2member-custom-reg-field-configuration-tools-form-id">Unique Field ID: *</label></label>';
												form += '</td>';
												form += '</tr>';
												/**/
												form += '<tr class="ws-plugin--s2member-custom-reg-field-configuration-tools-form-id">';
												form += '<td colspan="2">';
												form += '<input type="text" property="id" value="' + esc_attr (field.id) + '" maxlength="25" id="ws-plugin--s2member-custom-reg-field-configuration-tools-form-id" /><br />';
												form += '<small>Examples: <code>country_code</code>, <code>street_address</code></small><br />';
												form += '<small>e.g. <code>&lt;?php echo get_user_field("country_code"); ?&gt;</code></small>';
												form += '</td>';
												form += '</tr>';
												/**/
												form += '<tr class="ws-plugin--s2member-custom-reg-field-configuration-tools-form-spacer"><td colspan="2">&nbsp;</td></tr>';
												/**/
												form += '<tr class="ws-plugin--s2member-custom-reg-field-configuration-tools-form-required">';
												form += '<td colspan="2">';
												form += '<label for="ws-plugin--s2member-custom-reg-field-configuration-tools-form-required">Field Required: *</label>';
												form += '</td>';
												form += '</tr>';
												/**/
												form += '<tr class="ws-plugin--s2member-custom-reg-field-configuration-tools-form-required">';
												form += '<td colspan="2">';
												form += '<select property="required" id="ws-plugin--s2member-custom-reg-field-configuration-tools-form-required">';
												form += '<option value="yes"' + ( (field.required === 'yes') ? ' selected="selected"' : '') + '">Yes ( required )</option>';
												form += '<option value="no"' + ( (field.required === 'no') ? ' selected="selected"' : '') + '">No ( optional )</option>';
												form += '</select><br />';
												form += '<small>If <code>yes</code>, only Users/Members will be "required" to enter this field.</small><br />';
												form += '<small>* Administrators are exempt from this requirement.</small>';
												form += '</td>';
												form += '</tr>';
												/**/
												form += '<tr class="ws-plugin--s2member-custom-reg-field-configuration-tools-form-spacer"' + ( (field.type.match (/^(text|textarea|checkbox|pre_checkbox)$/)) ? ' style="display:none;"' : '') + '><td colspan="2">&nbsp;</td></tr>';
												/**/
												form += '<tr class="ws-plugin--s2member-custom-reg-field-configuration-tools-form-options"' + ( (field.type.match (/^(text|textarea|checkbox|pre_checkbox)$/)) ? ' style="display:none;"' : '') + '>';
												form += '<td colspan="2">';
												form += '<label for="ws-plugin--s2member-custom-reg-field-configuration-tools-form-options">Option Configuration File: * ( one option per line )</label><br />';
												form += '<small>Use a pipe <code>|</code> delimited format: <code>option value|option label</code></small>';
												form += '</td>';
												form += '</tr>';
												/**/
												form += '<tr class="ws-plugin--s2member-custom-reg-field-configuration-tools-form-options"' + ( (field.type.match (/^(text|textarea|checkbox|pre_checkbox)$/)) ? ' style="display:none;"' : '') + '>';
												form += '<td colspan="2">';
												form += '<textarea property="options" rows="3" wrap="off" spellcheck="false" id="ws-plugin--s2member-custom-reg-field-configuration-tools-form-options">' + esc_html (field.options) + '</textarea><br />';
												form += 'Here is a quick example:<br />';
												form += '<small>You can also specify a <em>default</em> option:</small><br />';
												form += '<code>US|United States|default</code><br />';
												form += '<code>CA|Canada</code><br />';
												form += '<code>VI|Virgin Islands (U.S.)</code>';
												form += '</td>';
												form += '</tr>';
												/**/
												form += '<tr class="ws-plugin--s2member-custom-reg-field-configuration-tools-form-spacer"' + ( (field.type.match (/^(select|selects|checkboxes|radios)$/)) ? ' style="display:none;"' : '') + '><td colspan="2">&nbsp;</td></tr>';
												/**/
												form += '<tr class="ws-plugin--s2member-custom-reg-field-configuration-tools-form-expected"' + ( (field.type.match (/^(select|selects|checkboxes|radios)$/)) ? ' style="display:none;"' : '') + '>';
												form += '<td colspan="2">';
												form += '<label for="ws-plugin--s2member-custom-reg-field-configuration-tools-form-expected">Expected Format: *</label>';
												form += '</td>';
												form += '</tr>';
												/**/
												form += '<tr class="ws-plugin--s2member-custom-reg-field-configuration-tools-form-expected"' + ( (field.type.match (/^(select|selects|checkboxes|radios)$/)) ? ' style="display:none;"' : '') + '>';
												form += '<td colspan="2">';
												form += '<select property="expected" id="ws-plugin--s2member-custom-reg-field-configuration-tools-form-expected">';
												/**/
												form += '<option value=""' + ( (field.expected === '') ? ' selected="selected"' : '') + '">Anything Goes</option>';
												form += '<option disabled="disabled"></option>';
												/**/
												form += '<optgroup label="Specific Input Types">';
												form += '<option value="numeric-wp-commas"' + ( (field.expected === 'numeric-wp-commas') ? ' selected="selected"' : '') + '">Numeric ( with or without decimals, commas allowed )</option>';
												form += '<option value="numeric"' + ( (field.expected === 'numeric') ? ' selected="selected"' : '') + '">Numeric ( with or without decimals, no commas )</option>';
												form += '<option value="integer"' + ( (field.expected === 'integer') ? ' selected="selected"' : '') + '">Integer ( whole number, without any decimals )</option>';
												form += '<option value="integer-gt-0"' + ( (field.expected === 'integer-gt-0') ? ' selected="selected"' : '') + '">Integer > 0 ( whole number, no decimals, greater than 0 )</option>';
												form += '<option value="float"' + ( (field.expected === 'float') ? ' selected="selected"' : '') + '">Float ( floating point number, decimals required )</option>';
												form += '<option value="float-gt-0"' + ( (field.expected === 'float-gt-0') ? ' selected="selected"' : '') + '">Float > 0 ( floating point number, decimals required, greater than 0 )</option>';
												form += '<option value="date"' + ( (field.expected === 'date') ? ' selected="selected"' : '') + '">Date ( required date format: dd/mm/yyyy )</option>';
												form += '<option value="email"' + ( (field.expected === 'email') ? ' selected="selected"' : '') + '">Email ( require valid email )</option>';
												form += '<option value="url"' + ( (field.expected === 'url') ? ' selected="selected"' : '') + '">Full URL ( starting with http or https )</option>';
												form += '<option value="domain"' + ( (field.expected === 'domain') ? ' selected="selected"' : '') + '">Domain Name ( domain name only, without http )</option>';
												form += '<option value="phone"' + ( (field.expected === 'phone') ? ' selected="selected"' : '') + '">Phone # ( 10 digits w/possible hyphens,spaces,brackets )</option>';
												form += '<option value="uszip"' + ( (field.expected === 'uszip') ? ' selected="selected"' : '') + '">US Zipcode ( 5-9 digits w/possible hyphen )</option>';
												form += '<option value="cazip"' + ( (field.expected === 'cazip') ? ' selected="selected"' : '') + '">Canadian Zipcode ( 6 alpha-numerics w/possible space )</option>';
												form += '<option value="uczip"' + ( (field.expected === 'uczip') ? ' selected="selected"' : '') + '">US/Canadian Zipcode ( either a US or Canadian zipcode )</option>';
												form += '</optgroup>';
												/**/
												form += '<option disabled="disabled"></option>';
												/**/
												form += '<optgroup label="Any Character Combination">';
												for (i = 1; i <= 25; i++)
													{
														form += '<option value="any-' + i + '"' + ( (field.expected === 'any-' + i) ? ' selected="selected"' : '') + '">Any Character Combination ( ' + i + ' character minimum )</option>';
														form += '<option value="any-' + i + '-e"' + ( (field.expected === 'any-' + i + '-e') ? ' selected="selected"' : '') + '">Any Character Combination ( exactly ' + i + ' character' + ( (i > 1) ? 's' : '') + ' )</option>';
													}
												form += '</optgroup>';
												/**/
												form += '<option disabled="disabled"></option>';
												/**/
												form += '<optgroup label="Alphanumerics, Spaces &amp; Punctuation Only">';
												for (i = 1; i <= 25; i++)
													{
														form += '<option value="alphanumerics-spaces-punctuation-' + i + '"' + ( (field.expected === 'alphanumerics-spaces-punctuation-' + i) ? ' selected="selected"' : '') + '">Alphanumerics, Spaces &amp; Punctuation ( ' + i + ' character minimum )</option>';
														form += '<option value="alphanumerics-spaces-punctuation-' + i + '-e"' + ( (field.expected === 'alphanumerics-spaces-punctuation-' + i + '-e') ? ' selected="selected"' : '') + '">Alphanumerics, Spaces &amp; Punctuation ( exactly ' + i + ' character' + ( (i > 1) ? 's' : '') + ' )</option>';
													}
												form += '</optgroup>';
												/**/
												form += '<option disabled="disabled"></option>';
												/**/
												form += '<optgroup label="Alphanumerics &amp; Spaces Only">';
												for (i = 1; i <= 25; i++)
													{
														form += '<option value="alphanumerics-spaces-' + i + '"' + ( (field.expected === 'alphanumerics-spaces-' + i) ? ' selected="selected"' : '') + '">Alphanumerics &amp; Spaces ( ' + i + ' character minimum )</option>';
														form += '<option value="alphanumerics-spaces-' + i + '-e"' + ( (field.expected === 'alphanumerics-spaces-' + i + '-e') ? ' selected="selected"' : '') + '">Alphanumerics &amp; Spaces ( exactly ' + i + ' character' + ( (i > 1) ? 's' : '') + ' )</option>';
													}
												form += '</optgroup>';
												/**/
												form += '<option disabled="disabled"></option>';
												/**/
												form += '<optgroup label="Alphanumerics &amp; Punctuation Only">';
												for (i = 1; i <= 25; i++)
													{
														form += '<option value="alphanumerics-punctuation-' + i + '"' + ( (field.expected === 'alphanumerics-punctuation-' + i) ? ' selected="selected"' : '') + '">Alphanumerics &amp; Punctuation ( ' + i + ' character minimum )</option>';
														form += '<option value="alphanumerics-punctuation-' + i + '-e"' + ( (field.expected === 'alphanumerics-punctuation-' + i + '-e') ? ' selected="selected"' : '') + '">Alphanumerics &amp; Punctuation ( exactly ' + i + ' character' + ( (i > 1) ? 's' : '') + ' )</option>';
													}
												form += '</optgroup>';
												/**/
												form += '<option disabled="disabled"></option>';
												/**/
												form += '<optgroup label="Alphanumerics Only">';
												for (i = 1; i <= 25; i++)
													{
														form += '<option value="alphanumerics-' + i + '"' + ( (field.expected === 'alphanumerics-' + i) ? ' selected="selected"' : '') + '">Alphanumerics ( ' + i + ' character minimum )</option>';
														form += '<option value="alphanumerics-' + i + '-e"' + ( (field.expected === 'alphanumerics-' + i + '-e') ? ' selected="selected"' : '') + '">Alphanumerics ( exactly ' + i + ' character' + ( (i > 1) ? 's' : '') + ' )</option>';
													}
												form += '</optgroup>';
												/**/
												form += '<option disabled="disabled"></option>';
												/**/
												form += '<optgroup label="Alphabetics Only">';
												for (i = 1; i <= 25; i++)
													{
														form += '<option value="alphabetics-' + i + '"' + ( (field.expected === 'alphabetics-' + i) ? ' selected="selected"' : '') + '">Alphabetics ( ' + i + ' character minimum )</option>';
														form += '<option value="alphabetics-' + i + '-e"' + ( (field.expected === 'alphabetics-' + i + '-e') ? ' selected="selected"' : '') + '">Alphabetics ( exactly ' + i + ' character' + ( (i > 1) ? 's' : '') + ' )</option>';
													}
												form += '</optgroup>';
												/**/
												form += '<option disabled="disabled"></option>';
												/**/
												form += '<optgroup label="Numeric Digits Only">';
												for (i = 1; i <= 25; i++)
													{
														form += '<option value="numerics-' + i + '"' + ( (field.expected === 'numerics-' + i) ? ' selected="selected"' : '') + '">Numeric Digits ( ' + i + ' digit minimum )</option>';
														form += '<option value="numerics-' + i + '-e"' + ( (field.expected === 'numerics-' + i + '-e') ? ' selected="selected"' : '') + '">Numeric Digits ( exactly ' + i + ' digit' + ( (i > 1) ? 's' : '') + ' )</option>';
													}
												form += '</optgroup>';
												/**/
												form += '</select><br />';
												form += '<small>Only Users/Members will be required to meet this criteria.</small><br />';
												form += '<small>* Administrators are exempt from this.</small>';
												form += '</td>';
												form += '</tr>';
												/**/
												form += '<tr class="ws-plugin--s2member-custom-reg-field-configuration-tools-form-spacer"><td colspan="2">&nbsp;</td></tr>';
												/**/
												form += '<tr class="ws-plugin--s2member-custom-reg-field-configuration-tools-form-levels">';
												form += '<td colspan="2">';
												form += '<label for="ws-plugin--s2member-custom-reg-field-configuration-tools-form-levels">Applicable Membership Levels: *</label>';
												form += '</td>';
												form += '</tr>';
												/**/
												form += '<tr class="ws-plugin--s2member-custom-reg-field-configuration-tools-form-levels">';
												form += '<td colspan="2">';
												form += '<input type="text" property="levels" value="' + esc_attr (field.levels) + '" id="ws-plugin--s2member-custom-reg-field-configuration-tools-form-levels" /><br />';
												form += '<small>Please use comma-delimited Level #\'s: <code>0,1,2,3,4</code> or type: <code>all</code>.</small><br />';
												form += '<small>This allows you to enable this field - only at specific Membership Levels.</small>';
												form += '</td>';
												form += '</tr>';
												/**/
												form += '<tr class="ws-plugin--s2member-custom-reg-field-configuration-tools-form-spacer"><td colspan="2">&nbsp;</td></tr>';
												/**/
												form += '<tr class="ws-plugin--s2member-custom-reg-field-configuration-tools-form-editable">';
												form += '<td colspan="2">';
												form += '<label for="ws-plugin--s2member-custom-reg-field-configuration-tools-form-editable">Allow Profile Edits: *</label>';
												form += '</td>';
												form += '</tr>';
												/**/
												form += '<tr class="ws-plugin--s2member-custom-reg-field-configuration-tools-form-editable">';
												form += '<td colspan="2">';
												form += '<select property="editable" id="ws-plugin--s2member-custom-reg-field-configuration-tools-form-editable">';
												form += '<option value="yes"' + ( (field.editable === 'yes') ? ' selected="selected"' : '') + '">Yes ( editable )</option>';
												form += '<option value="no"' + ( (field.editable === 'no') ? ' selected="selected"' : '') + '">No ( uneditable after registration )</option>';
												form += '<option value="no-invisible"' + ( (field.editable === 'no-invisible') ? ' selected="selected"' : '') + '">No ( uneditable &amp; totally invisible )</option>';
												form += '</select><br />';
												form += '<small>If <code>No</code>, this field will be un-editable after registration.</small><br />';
												form += '<small>* Administrators are exempt from this.</small>';
												form += '</td>';
												form += '</tr>';
												/**/
												form += '<tr class="ws-plugin--s2member-custom-reg-field-configuration-tools-form-spacer"><td colspan="2">&nbsp;</td></tr>';
												/**/
												form += '<tr class="ws-plugin--s2member-custom-reg-field-configuration-tools-form-classes">';
												form += '<td colspan="2">';
												form += '<label for="ws-plugin--s2member-custom-reg-field-configuration-tools-form-classes">CSS Classes: ( optional )</label>';
												form += '</td>';
												form += '</tr>';
												/**/
												form += '<tr class="ws-plugin--s2member-custom-reg-field-configuration-tools-form-classes">';
												form += '<td colspan="2">';
												form += '<input type="text" property="classes" value="' + esc_attr (field.classes) + '" id="ws-plugin--s2member-custom-reg-field-configuration-tools-form-classes" /><br />';
												form += '<small>Example: <code>my-style-1 my-style-2</code></small>';
												form += '</td>';
												form += '</tr>';
												/**/
												form += '<tr class="ws-plugin--s2member-custom-reg-field-configuration-tools-form-spacer"><td colspan="2">&nbsp;</td></tr>';
												/**/
												form += '<tr class="ws-plugin--s2member-custom-reg-field-configuration-tools-form-styles">';
												form += '<td colspan="2">';
												form += '<label for="ws-plugin--s2member-custom-reg-field-configuration-tools-form-styles">CSS Styles: ( optional )</label>';
												form += '</td>';
												form += '</tr>';
												/**/
												form += '<tr class="ws-plugin--s2member-custom-reg-field-configuration-tools-form-styles">';
												form += '<td colspan="2">';
												form += '<input type="text" property="styles" value="' + esc_attr (field.styles) + '" id="ws-plugin--s2member-custom-reg-field-configuration-tools-form-styles" /><br />';
												form += '<small>Example: <code>color:#000000; background:#FFFFFF;</code></small>';
												form += '</td>';
												form += '</tr>';
												/**/
												form += '<tr class="ws-plugin--s2member-custom-reg-field-configuration-tools-form-spacer"><td colspan="2">&nbsp;</td></tr>';
												/**/
												form += '<tr class="ws-plugin--s2member-custom-reg-field-configuration-tools-form-attrs">';
												form += '<td colspan="2">';
												form += '<label for="ws-plugin--s2member-custom-reg-field-configuration-tools-form-attrs">Other Attributes: ( optional )</label>';
												form += '</td>';
												form += '</tr>';
												/**/
												form += '<tr class="ws-plugin--s2member-custom-reg-field-configuration-tools-form-attrs">';
												form += '<td colspan="2">';
												form += '<input type="text" property="attrs" value="' + esc_attr (field.attrs) + '" id="ws-plugin--s2member-custom-reg-field-configuration-tools-form-attrs" /><br />';
												form += '<small>Example: <code>onkeyup="" onblur=""</code></small>';
												form += '</td>';
												form += '</tr>';
												/**/
												form += '<tr class="ws-plugin--s2member-custom-reg-field-configuration-tools-form-spacer"><td colspan="2">&nbsp;</td></tr>';
												/**/
												form += '<tr class="ws-plugin--s2member-custom-reg-field-configuration-tools-form-buttons">';
												form += '<td align="left">';
												form += '<input type="button" value="Cancel" onclick="ws_plugin__s2member_customRegFieldCancel();" />';
												form += '</td>';
												form += '<td align="right">';
												form += '<input type="button" value="' + ( (editing) ? 'Update This Field' : 'Create Registration Field') + '" onclick="' + ( (editing) ? 'ws_plugin__s2member_customRegFieldUpdate(' + index + ');' : 'ws_plugin__s2member_customRegFieldCreate();') + '" />';
												form += '</td>';
												form += '</tr>';
												/**/
												form += '</tbody>';
												form += '</table>';
												/**/
												form += '<div>';
												/**/
												$ ('body').append (form);
												tb_show ( ( (editing) ? 'Editing Registration Field' : 'New Custom Registration Field'), '#TB_inline?inlineId=ws-plugin--s2member-custom-reg-field-configuration-thickbox-tools-form');
												$ (window).trigger ('resize'), $ ('table#ws-plugin--s2member-custom-reg-field-configuration-tools-form').show ();
											}
										/**/
										$tools.html (html);
									};
								/**/
								var attachTBResizer = function() /* Resize inline #TB_ajaxContent. */
									{
										$ (window).resize (function()
											{
												var w, h; /* Initialize width/height vars. */
												w = $ (window).width (), h = $ (window).height (), w = (w > 720) ? 720 : w;
												$ ('#TB_ajaxContent').css ({'width': w - 50, 'height': h - 75, 'margin': 0, 'padding': 0});
											});
									};
								/**/
								var buildTable = function() /* This builds the table of existing fields. */
									{
										var l = fields.length, i = 0, field, html = '', eo = 'o';
										/**/
										html += '<tbody>';
										/**/
										html += '<tr>';
										html += '<th>Order</th>';
										html += '<th>Field Type</th>';
										html += '<th>Unique ID</th>';
										html += '<th>Required</th>';
										html += '<th>Levels</th>';
										html += '<th>- Tools -</th>';
										html += '</tr>';
										/**/
										if (fields.length > 0)
											{
												for (i = 0; i < fields.length; i++)
													{
														eo = (eo === 'o') ? 'e' : 'o';
														field = fields[i]; /* Obj. */
														/**/
														html += '<tr class="' + esc_attr (eo) + ' ws-plugin--s2member-custom-reg-field-configuration-table-row-' + i + '">'; /* Odd/even + row identifier. */
														html += '<td nowrap="nowrap"><a class="ws-plugin--s2member-custom-reg-field-configuration-move-up" href="#" onclick="ws_plugin__s2member_customRegFieldMoveUp(' + i + '); return false;"></a><a class="ws-plugin--s2member-custom-reg-field-configuration-move-down" href="#" onclick="ws_plugin__s2member_customRegFieldMoveDown(' + i + '); return false;"></a></td>';
														html += '<td nowrap="nowrap">' + esc_html (fieldTypeDesc (field.type)) + '</td>';
														html += '<td nowrap="nowrap">' + esc_html (field.id) + '</td>';
														html += '<td nowrap="nowrap">' + esc_html (field.required) + '</td>';
														html += '<td nowrap="nowrap">' + esc_html (field.levels) + '</td>';
														html += '<td nowrap="nowrap"><a class="ws-plugin--s2member-custom-reg-field-configuration-edit" href="#" onclick="ws_plugin__s2member_customRegFieldEdit(' + i + '); return false;"></a><a class="ws-plugin--s2member-custom-reg-field-configuration-delete" href="#" onclick="ws_plugin__s2member_customRegFieldDelete(' + i + '); return false;"></a></td>';
														html += '</tr>';
													}
											}
										else /* Otherwise, there are no fields configured yet. */
											{
												html += '<tr>'; /* There are no fields yet. */
												html += '<td colspan="6">No Custom Fields are configured.</td>';
												html += '</tr>';
											}
										/**/
										html += '</tbody>';
										/**/
										$table.html (html);
									};
								/* Initialize configuration. */
								buildTools (), attachTBResizer (), buildTable ();
							/**/
							}) ();
					}
				/**/
				$ ('input#ws-plugin--s2member-ip-restrictions-reset-button').click (function()
					{
						var $this = $ (this); /* Save $(this) into $this. */
						$this.val ('one moment please ...'); /* Indicate loading status ( please wait ). */
						/**/
						$.post (ajaxurl, {action: 'ws_plugin__s2member_delete_reset_all_ip_restrictions_via_ajax', ws_plugin__s2member_delete_reset_all_ip_restrictions_via_ajax: '<?php echo ws_plugin__s2member_esc_sq (wp_create_nonce ("ws-plugin--s2member-delete-reset-all-ip-restrictions-via-ajax")); ?>'}, function(response)
							{
								alert ('s2Member\'s IP Restriction Logs have all been reset.'), $this.val ('Reset IP Restriction Logs');
							});
						/**/
						return false;
					});
			}
		/**/
		else if (location.href.match (/page\=ws-plugin--s2member-paypal-ops/))
			{
				$ ('select#ws-plugin--s2member-auto-eot-system-enabled').change (function()
					{
						var $this = $ (this), val = $this.val ();
						var $viaCron = $ ('p#ws-plugin--s2member-auto-eot-system-enabled-via-cron');
						/**/
						if (val == 2) /* Display Cron instructions. */
							$viaCron.show ()
						else /* Hide instructions. */
							$viaCron.hide ();
					});
			}
		/**/
		else if (location.href.match (/page\=ws-plugin--s2member-els-ops/))
			{
				$ ('select#ws-plugin--s2member-custom-reg-opt-in').change (function()
					{
						var $this = $ (this), val = $this.val ();
						var $rows = $ ('tr.ws-plugin--s2member-custom-reg-opt-in-label-row');
						var $prevImg = $ ('img.ws-plugin--s2member-custom-reg-opt-in-label-prev-img');
						/**/
						if (val <= 0) /* Checkbox disabled. */
							$rows.css ('display', 'none'), $prevImg.attr ('src', $prevImg.attr ('src').replace (/\/checked\.png$/, '/unchecked.png'));
						/**/
						else if (val == 1) /* Enabled, checked by default. */
							$rows.css ('display', ''), $prevImg.attr ('src', $prevImg.attr ('src').replace (/\/unchecked\.png$/, '/checked.png'));
						/**/
						else if (val == 2) /* Enabled, unchecked by default. */
							$rows.css ('display', ''), $prevImg.attr ('src', $prevImg.attr ('src').replace (/\/checked\.png$/, '/unchecked.png'));
					});
			}
		/**/
		else if (location.href.match (/page\=ws-plugin--s2member-paypal-buttons/))
			{
				$ ('select#ws-plugin--s2member-level1-term, select#ws-plugin--s2member-level2-term, select#ws-plugin--s2member-level3-term, select#ws-plugin--s2member-level4-term, select#ws-plugin--s2member-modification-term').change (function()
					{
						var button = this.id.replace (/^ws-plugin--s2member-(.+?)-term$/g, '$1');
						/**/
						var trialDisabled = ($ (this).val ().split ('-')[2].replace (/[^0-1BN]/g, '') === 'BN') ? 1 : 0;
						/**/
						$ ('p#ws-plugin--s2member-' + button + '-trial-line').css ('display', (trialDisabled ? 'none' : ''));
						$ ('span#ws-plugin--s2member-' + button + '-trial-then').css ('display', (trialDisabled ? 'none' : ''));
						$ ('span#ws-plugin--s2member-' + button + '-20p-rule').css ('display', (trialDisabled ? 'none' : ''));
						/**/
						(trialDisabled) ? $ ('input#ws-plugin--s2member-' + form + '-trial-period').val (0) : null;
						(trialDisabled) ? $ ('input#ws-plugin--s2member-' + form + '-trial-amount').val ('0.00') : null;
					});
				/**/
				$ ('input#ws-plugin--s2member-level1-ccaps, input#ws-plugin--s2member-level2-ccaps, input#ws-plugin--s2member-level3-ccaps, input#ws-plugin--s2member-level4-ccaps, input#ws-plugin--s2member-modification-ccaps').keyup (function()
					{
						if (this.value.match (/[^a-z_0-9,]/)) /* Only if there is a problem; because this causes interruption. */
							this.value = $.trim ($.trim (this.value).replace (/[ \-]/g, '_').replace (/[^A-Z_0-9,]/gi, '').toLowerCase ());
					});
				/**/
				ws_plugin__s2member_paypalButtonGenerate = function(button) /* Handles PayPal® Button Generation. */
					{
						var shortCodeTemplate = '[s2Member-PayPal-Button %%attrs%% image="default" output="button" /]', shortCodeTemplateAttrs = '', labels = {};
						/**/
						labels['level0'] = '<?php echo ws_plugin__s2member_esc_sq ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level0_label"]); ?>';
						labels['level1'] = '<?php echo ws_plugin__s2member_esc_sq ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_label"]); ?>';
						labels['level2'] = '<?php echo ws_plugin__s2member_esc_sq ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_label"]); ?>';
						labels['level3'] = '<?php echo ws_plugin__s2member_esc_sq ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_label"]); ?>';
						labels['level4'] = '<?php echo ws_plugin__s2member_esc_sq ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_label"]); ?>';
						/**/
						var shortCode = $ ('input#ws-plugin--s2member-' + button + '-shortcode');
						var code = $ ('textarea#ws-plugin--s2member-' + button + '-button');
						var modLevel = $ ('select#ws-plugin--s2member-modification-level');
						/**/
						var level = (button === 'modification') ? modLevel.val ().split (':', 2)[1] : button.replace (/^level/, '');
						var label = labels['level' + level].replace (/"/g, ""); /* Labels may NOT contain any double-quotes. */
						var desc = $.trim ($ ('input#ws-plugin--s2member-' + button + '-desc').val ().replace (/"/g, ""));
						/**/
						var trialAmount = $ ('input#ws-plugin--s2member-' + button + '-trial-amount').val ().replace (/[^0-9\.]/g, '');
						var trialPeriod = $ ('input#ws-plugin--s2member-' + button + '-trial-period').val ().replace (/[^0-9]/g, '');
						var trialTerm = $ ('select#ws-plugin--s2member-' + button + '-trial-term').val ().replace (/[^A-Z]/g, '');
						/**/
						var regAmount = $ ('input#ws-plugin--s2member-' + button + '-amount').val ().replace (/[^0-9\.]/g, '');
						var regPeriod = $ ('select#ws-plugin--s2member-' + button + '-term').val ().split ('-')[0].replace (/[^0-9]/g, '');
						var regTerm = $ ('select#ws-plugin--s2member-' + button + '-term').val ().split ('-')[1].replace (/[^A-Z]/g, '');
						var regRecur = $ ('select#ws-plugin--s2member-' + button + '-term').val ().split ('-')[2].replace (/[^0-1BN]/g, '');
						/**/
						var pageStyle = $.trim ($ ('input#ws-plugin--s2member-' + button + '-page-style').val ().replace (/"/g, ''));
						var currencyCode = $ ('select#ws-plugin--s2member-' + button + '-currency').val ().replace (/[^A-Z]/g, '');
						var cCaps = $.trim ($.trim ($ ('input#ws-plugin--s2member-' + button + '-ccaps').val ()).replace (/[ \-]/g, '_').replace (/[^A-Z_0-9,]/gi, '').toLowerCase ());
						/**/
						trialPeriod = (regRecur === 'BN') ? '0' : trialPeriod; /* Lifetime ( 1-L-BN ) and Buy Now ( BN ) access is absolutely NOT compatible w/ Free Trials. */
						trialAmount = (!trialAmount || isNaN (trialAmount) || trialAmount < 0.01 || trialPeriod <= 0) ? '0' : trialAmount; /* Validate Trial Amount. */
						/**/
						var levelCcapsPer = (regRecur === 'BN' && regTerm !== 'L') ? level + ':' + cCaps + ':' + regPeriod + ' ' + regTerm : level + ':' + cCaps;
						levelCcapsPer = levelCcapsPer.replace (/\:+$/g, ''); /* Clean any trailing separators from this string. */
						/**/
						if (trialAmount && (isNaN (trialAmount) || trialAmount < 0.00))
							{
								alert ('Oops, a slight problem:\n\nWhen provided, Trial Amount must be >= 0.00');
								return false;
							}
						else if (trialAmount && trialAmount > 10000.00) /* $10,000.00 maximum. */
							{
								alert ('Oops, a slight problem:\n\nMaximum Trial Amount is: 10000.00');
								return false;
							}
						else if (trialTerm === 'D' && trialPeriod > 7) /* Some validation on the Trial Period. Max days: 7. */
							{
								alert ('Oops, a slight problem:\n\nMaximum Free Days is: 7.\nIf you want to offer more than 7 days free, please choose Weeks or Months from the drop-down.');
								return false;
							}
						else if (trialTerm === 'W' && trialPeriod > 52) /* Some validation on the Trial Period. 52 max. */
							{
								alert ('Oops, a slight problem:\n\nMaximum Free Weeks is: 52.\nIf you want to offer more than 52 weeks free, please choose Months from the drop-down.');
								return false;
							}
						else if (trialTerm === 'M' && trialPeriod > 12) /* Some validation on the Trial Period. 12 max. */
							{
								alert ('Oops, a slight problem:\n\nMaximum Free Months is: 12.\nIf you want to offer more than 12 months free, please choose Years from the drop-down.');
								return false;
							}
						else if (trialTerm === 'Y' && trialPeriod > 1) /* 1 year max. */
							{
								alert ('Oops, a slight problem:\n\nMax Trial Period Years is: 1.');
								return false;
							}
						else if (!regAmount || isNaN (regAmount) || regAmount < 0.01)
							{
								alert ('Oops, a slight problem:\n\nAmount must be >= 0.01');
								return false;
							}
						else if (regAmount > 10000.00) /* $10,000.00 maximum. */
							{
								alert ('Oops, a slight problem:\n\nMaximum amount is: 10000.00');
								return false;
							}
						else if (!desc) /* Each Button should have a Description. */
							{
								alert ('Oops, a slight problem:\n\nPlease type a Description for this Button.');
								return false;
							}
						/**/
						code.html (code.val ().replace (/ \<\!--(\<input type\="hidden" name\="(amount|src|sra|a1|p1|t1|a3|p3|t3)" value\="(.*?)" \/\>)--\>/g, " $1"));
						(parseInt (trialPeriod) <= 0) ? code.html (code.val ().replace (/ (\<input type\="hidden" name\="(a1|p1|t1)" value\="(.*?)" \/\>)/g, " <!--$1-->")) : null;
						(regRecur === 'BN') ? code.html (code.val ().replace (/ (\<input type\="hidden" name\="cmd" value\=")(.*?)(" \/\>)/g, " $1_xclick$3")) : null;
						(regRecur === 'BN') ? code.html (code.val ().replace (/ (\<input type\="hidden" name\="(src|sra|a1|p1|t1|a3|p3|t3)" value\="(.*?)" \/\>)/g, " <!--$1-->")) : null;
						(regRecur !== 'BN') ? code.html (code.val ().replace (/ (\<input type\="hidden" name\="cmd" value\=")(.*?)(" \/\>)/g, " $1_xclick-subscriptions$3")) : null;
						(regRecur !== 'BN') ? code.html (code.val ().replace (/ (\<input type\="hidden" name\="amount" value\="(.*?)" \/\>)/g, " <!--$1-->")) : null;
						/**/
						shortCodeTemplateAttrs += 'level="' + esc_attr (level) + '" ccaps="' + esc_attr (cCaps) + '" desc="' + esc_attr (desc) + '" ps="' + esc_attr (pageStyle) + '" cc="' + esc_attr (currencyCode) + '" ns="1" custom="<?php echo ws_plugin__s2member_esc_sq (esc_attr ($_SERVER["HTTP_HOST"])); ?>"';
						shortCodeTemplateAttrs += ' ta="' + esc_attr (trialAmount) + '" tp="' + esc_attr (trialPeriod) + '" tt="' + esc_attr (trialTerm) + '" ra="' + esc_attr (regAmount) + '" rp="' + esc_attr (regPeriod) + '" rt="' + esc_attr (regTerm) + '" rr="' + esc_attr (regRecur) + '"';
						shortCodeTemplateAttrs += (button === 'modification') ? ' modify="1"' : ''; /* For Modification Buttons. */
						shortCode.val (shortCodeTemplate.replace (/%%attrs%%/, shortCodeTemplateAttrs));
						/**/
						code.html (code.val ().replace (/ name\="item_name" value\="(.*?)"/, ' name="item_name" value="' + esc_attr (desc) + '"'));
						code.html (code.val ().replace (/ name\="item_number" value\="(.*?)"/, ' name="item_number" value="' + esc_attr (levelCcapsPer) + '"'));
						code.html (code.val ().replace (/ name\="page_style" value\="(.*?)"/, ' name="page_style" value="' + esc_attr (pageStyle) + '"'));
						code.html (code.val ().replace (/ name\="currency_code" value\="(.*?)"/, ' name="currency_code" value="' + esc_attr (currencyCode) + '"'));
						code.html (code.val ().replace (/ name\="custom" value\="(.*?)"/, ' name="custom" value="<?php echo ws_plugin__s2member_esc_sq (esc_attr ($_SERVER["HTTP_HOST"])); ?>"'));
						code.html (code.val ().replace (/ name\="modify" value\="(.*?)"/, ' name="modify" value="' + ( (button === 'modification') ? '1' : '0') + '"'));
						code.html (code.val ().replace (/ name\="amount" value\="(.*?)"/, ' name="amount" value="' + esc_attr (regAmount) + '"'));
						code.html (code.val ().replace (/ name\="src" value\="(.*?)"/, ' name="src" value="' + esc_attr (regRecur) + '"'));
						code.html (code.val ().replace (/ name\="a1" value\="(.*?)"/, ' name="a1" value="' + esc_attr (trialAmount) + '"'));
						code.html (code.val ().replace (/ name\="p1" value\="(.*?)"/, ' name="p1" value="' + esc_attr (trialPeriod) + '"'));
						code.html (code.val ().replace (/ name\="t1" value\="(.*?)"/, ' name="t1" value="' + esc_attr (trialTerm) + '"'));
						code.html (code.val ().replace (/ name\="a3" value\="(.*?)"/, ' name="a3" value="' + esc_attr (regAmount) + '"'));
						code.html (code.val ().replace (/ name\="p3" value\="(.*?)"/, ' name="p3" value="' + esc_attr (regPeriod) + '"'));
						code.html (code.val ().replace (/ name\="t3" value\="(.*?)"/, ' name="t3" value="' + esc_attr (regTerm) + '"'));
						/**/
						$ ('div#ws-plugin--s2member-' + button + '-button-prev').html (code.val ().replace (/\<form/, '<form target="_blank"').replace (/\<\?php echo S2MEMBER_CURRENT_USER_VALUE_FOR_PP_(ON0|OS0); \?\>/g, ''));
						/**/
						(button === 'modification') ? alert ('Your Modification Button has been generated.\nPlease copy/paste the Shortcode Format into your Login Welcome Page, or wherever you feel it would be most appropriate.') : alert ('Your Button has been generated.\nPlease copy/paste the Shortcode Format into your Membership Options Page.');
						/**/
						shortCode.each (function() /* Focus and select the recommended Shortcode. */
							{
								this.focus (), this.select ();
							});
						/**/
						return false;
					};
				/**/
				ws_plugin__s2member_paypalSpButtonGenerate = function() /* Handles PayPal® Button Generation for Specific Post/Page Access. */
					{
						var shortCodeTemplate = '[s2Member-PayPal-Button %%attrs%% image="default" output="button" /]', shortCodeTemplateAttrs = '';
						/**/
						var shortCode = $ ('input#ws-plugin--s2member-sp-shortcode');
						var code = $ ('textarea#ws-plugin--s2member-sp-button');
						/**/
						var leading = $ ('select#ws-plugin--s2member-sp-leading-id').val ().replace (/[^0-9]/g, '');
						var additionals = $ ('select#ws-plugin--s2member-sp-additional-ids').val () || [];
						var hours = $ ('select#ws-plugin--s2member-sp-hours').val ().replace (/[^0-9]/g, '');
						var regAmount = $ ('input#ws-plugin--s2member-sp-amount').val ().replace (/[^0-9\.]/g, '');
						var desc = $.trim ($ ('input#ws-plugin--s2member-sp-desc').val ().replace (/"/g, ''));
						var pageStyle = $.trim ($ ('input#ws-plugin--s2member-sp-page-style').val ().replace (/"/g, ''));
						var currencyCode = $ ('select#ws-plugin--s2member-sp-currency').val ().replace (/[^A-Z]/g, '');
						/**/
						if (!leading) /* Must have a Leading Post/Page ID to work with. Otherwise, Link generation will fail. */
							{
								alert ('Oops, a slight problem:\n\nPlease select a Leading Post/Page.\n\n*Tip* If there are no Posts/Pages in the menu, it\'s because you\'ve not configured s2Member for Specific Post/Page Access yet. See: s2Member -> General Options -> Specific Post/Page Access Restrictions.');
								return false;
							}
						else if (!regAmount || isNaN (regAmount) || regAmount < 0.01)
							{
								alert ('Oops, a slight problem:\n\nAmount must be >= 0.01');
								return false;
							}
						else if (regAmount > 10000.00) /* $10,000.00 maximum. */
							{
								alert ('Oops, a slight problem:\n\nMaximum amount is: 10000.00');
								return false;
							}
						else if (!desc) /* Each Button should have a Description. */
							{
								alert ('Oops, a slight problem:\n\nPlease type a Description for this Button.');
								return false;
							}
						/**/
						for (var i = 0, ids = leading; i < additionals.length; i++)
							if (additionals[i] && additionals[i] !== leading)
								ids += ',' + additionals[i];
						/**/
						var spIdsHours = 'sp:' + ids + ':' + hours; /* Combined sp:ids:expiration hours. */
						/**/
						shortCodeTemplateAttrs += 'ids="' + esc_attr (ids) + '" exp="' + esc_attr (hours) + '" desc="' + esc_attr (desc) + '" ps="' + esc_attr (pageStyle) + '" cc="' + esc_attr (currencyCode) + '" ns="1"';
						shortCodeTemplateAttrs += ' custom="<?php echo ws_plugin__s2member_esc_sq (esc_attr ($_SERVER["HTTP_HOST"])); ?>" ra="' + esc_attr (regAmount) + '" sp="1"';
						shortCode.val (shortCodeTemplate.replace (/%%attrs%%/, shortCodeTemplateAttrs));
						/**/
						code.html (code.val ().replace (/ name\="item_name" value\="(.*?)"/, ' name="item_name" value="' + esc_attr (desc) + '"'));
						code.html (code.val ().replace (/ name\="item_number" value\="(.*?)"/, ' name="item_number" value="' + esc_attr (spIdsHours) + '"'));
						code.html (code.val ().replace (/ name\="page_style" value\="(.*?)"/, ' name="page_style" value="' + esc_attr (pageStyle) + '"'));
						code.html (code.val ().replace (/ name\="currency_code" value\="(.*?)"/, ' name="currency_code" value="' + esc_attr (currencyCode) + '"'));
						code.html (code.val ().replace (/ name\="custom" value\="(.*?)"/, ' name="custom" value="<?php echo ws_plugin__s2member_esc_sq (esc_attr ($_SERVER["HTTP_HOST"])); ?>"'));
						code.html (code.val ().replace (/ name\="amount" value\="(.*?)"/, ' name="amount" value="' + esc_attr (regAmount) + '"'));
						/**/
						$ ('div#ws-plugin--s2member-sp-button-prev').html (code.val ().replace (/\<form/, '<form target="_blank"'));
						/**/
						alert ('Your Button has been generated.\nPlease copy/paste the Shortcode Format into your Membership Options Page.');
						/**/
						shortCode.each (function() /* Focus and select the recommended Shortcode. */
							{
								this.focus (), this.select ();
							});
						/**/
						return false;
					};
				/**/
				ws_plugin__s2member_paypalSpLinkGenerate = function() /* Handles PayPal® Link Generation. */
					{
						var leading = $ ('select#ws-plugin--s2member-sp-link-leading-id').val ().replace (/[^0-9]/g, '');
						var additionals = $ ('select#ws-plugin--s2member-sp-link-additional-ids').val () || [];
						var hours = $ ('select#ws-plugin--s2member-sp-link-hours').val ().replace (/[^0-9]/g, '');
						var $link = $ ('p#ws-plugin--s2member-sp-link'), $loading = $ ('img#ws-plugin--s2member-sp-link-loading');
						/**/
						if (!leading) /* Must have a Leading Post/Page ID to work with. Otherwise, Link generation will fail. */
							{
								alert ('Oops, a slight problem:\n\nPlease select a Leading Post/Page.\n\n*Tip* If there are no Posts/Pages in the menu, it\'s because you\'ve not configured s2Member for Specific Post/Page Access yet. See: s2Member -> General Options -> Specific Post/Page Access Restrictions.');
								return false;
							}
						/**/
						for (var i = 0, ids = leading; i < additionals.length; i++)
							if (additionals[i] && additionals[i] !== leading)
								ids += ',' + additionals[i];
						/**/
						$link.hide (), $loading.show (), $.post (ajaxurl, {action: 'ws_plugin__s2member_sp_access_link_via_ajax', ws_plugin__s2member_sp_access_link_via_ajax: '<?php echo ws_plugin__s2member_esc_sq (wp_create_nonce ("ws-plugin--s2member-sp-access-link-via-ajax")); ?>', s2member_sp_access_link_ids: ids, s2member_sp_access_link_hours: hours}, function(response)
							{
								$link.show ().html ('<a href="' + esc_attr (response) + '" target="_blank" rel="external">' + esc_html (response) + '</a>'), $loading.hide ();
							});
						/**/
						return false;
					};
			}
	});