<?php
/*
Copyright: © 2009 WebSharks, Inc. ( coded in the USA )
<mailto:support@websharks-inc.com> <http://www.websharks-inc.com/>

Released under the terms of the GNU General Public License.
You should have received a copy of the GNU General Public License,
along with this software. In the main directory, see: /licensing/
If not, see: <http://www.gnu.org/licenses/>.
*/
/*
Direct access denial.
*/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit ("Do not access this file directly.");
/*
Function adds meta boxes to Post/Page editing stations.
Attach to: add_action("admin_menu");
*/
if (!function_exists ("ws_plugin__s2member_add_meta_boxes"))
	{
		function ws_plugin__s2member_add_meta_boxes ()
			{
				do_action ("ws_plugin__s2member_before_add_meta_boxes", get_defined_vars ());
				/**/
				foreach (get_post_types () as $type) /* Handles Custom Post Types as well. */
					if (!in_array ($type, array ("revision", "attachment", "nav_menu_item"))) /* But NOT on these Post Types. */
						add_meta_box ("ws-plugin--s2member-security", "s2Member", "ws_plugin__s2member_security_meta_box", $type, "side", "high");
				/**/
				do_action ("ws_plugin__s2member_after_add_meta_boxes", get_defined_vars ());
				/**/
				return;
			}
	}
/*
Function adds meta boxes to Post/Page editing stations.
Attach to: add_action("admin_menu");
*/
if (!function_exists ("ws_plugin__s2member_security_meta_box"))
	{
		function ws_plugin__s2member_security_meta_box ($post = FALSE)
			{
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_security_meta_box", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				if (is_object ($post) && ($post_id = $post->ID) && ( ($post->post_type === "page" && current_user_can ("edit_page", $post_id)) || current_user_can ("edit_post", $post_id)))
					{
						if ($post->post_type === "page" && ($page_id = $post_id)) /* OK. So we're dealing with a Page classification. */
							{
								if (!in_array ($page_id, array ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"], $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_welcome_page"], $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["file_download_limit_exceeded_page"])))
									{
										echo '<input type="hidden" name="ws_plugin__s2member_security_meta_box_save" id="ws-plugin--s2member-security-meta-box-save" value="' . esc_attr (wp_create_nonce ("ws-plugin--s2member-security-meta-box-save")) . '" />' . "\n";
										echo '<input type="hidden" name="ws_plugin__s2member_security_meta_box_save_id" id="ws-plugin--s2member-security-meta-box-save-id" value="' . esc_attr ($page_id) . '" />' . "\n";
										/**/
										$pages["0"] = preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level0_pages"]);
										$pages["1"] = preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_pages"]);
										$pages["2"] = preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_pages"]);
										$pages["3"] = preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_pages"]);
										$pages["4"] = preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_pages"]);
										/**/
										echo '<p style="margin-left:2px;"><strong>Page Level Restriction?</strong></p>' . "\n";
										echo '<label class="screen-reader-text" for="ws-plugin--s2member-security-meta-box-level">Add Level Restriction?</label>' . "\n";
										echo '<select name="ws_plugin__s2member_security_meta_box_level" id="ws-plugin--s2member-security-meta-box-level" style="width:99%;">' . "\n";
										echo '<option value=""></option>' . "\n"; /* By default, we allow public access to any Post/Page. */
										echo ($pages["0"] !== array ("all")) ? '<option value="0"' . ( (in_array ($page_id, $pages["0"])) ? ' selected="selected"' : '') . '>Require Level# 0 ( or higher )</option>' . "\n" : '<option value="" disabled="disabled">Level #0 ( already protects "all" Pages )</option>';
										echo ($pages["1"] !== array ("all")) ? '<option value="1"' . ( (in_array ($page_id, $pages["1"])) ? ' selected="selected"' : '') . '>Require Level# 1 ( or higher )</option>' . "\n" : '<option value="" disabled="disabled">Level #1 ( already protects "all" Pages )</option>';
										echo ($pages["2"] !== array ("all")) ? '<option value="2"' . ( (in_array ($page_id, $pages["2"])) ? ' selected="selected"' : '') . '>Require Level# 2 ( or higher )</option>' . "\n" : '<option value="" disabled="disabled">Level #2 ( already protects "all" Pages )</option>';
										echo ($pages["3"] !== array ("all")) ? '<option value="3"' . ( (in_array ($page_id, $pages["3"])) ? ' selected="selected"' : '') . '>Require Level# 3 ( or higher )</option>' . "\n" : '<option value="" disabled="disabled">Level #3 ( already protects "all" Pages )</option>';
										echo ($pages["4"] !== array ("all")) ? '<option value="4"' . ( (in_array ($page_id, $pages["4"])) ? ' selected="selected"' : '') . '>Require Level# 4 ( highest level )</option>' . "\n" : '<option value="" disabled="disabled">Level #4 ( already protects "all" Pages )</option>';
										echo '</select><br /><small>* see: <code>General Options -> Page Level Access</code></small>' . "\n";
										/**/
										if (!is_multisite () || !ws_plugin__s2member_is_multisite_farm () || is_main_site ())
											/* ^ Will change once Custom Capabilities are compatible with a Blog Farm. */
											{
												echo '<p style="margin-top:15px; margin-left:2px;"><strong>Require Custom Capabilities?</strong></p>' . "\n";
												echo '<label class="screen-reader-text" for="ws-plugin--s2member-security-meta-box-ccaps">Custom Capabilities?</label>' . "\n";
												echo '<input type="text" name="ws_plugin__s2member_security_meta_box_ccaps" id="ws-plugin--s2member-security-meta-box-ccaps" value="' . format_to_edit (implode (",", (array)get_post_meta ($page_id, "s2member_ccaps_req", true))) . '" onkeyup="if(this.value.match(/[^a-z_0-9,]/)) this.value = jQuery.trim (jQuery.trim (this.value).replace (/[ \-]/g, \'_\').replace (/[^A-Z_0-9,]/gi, \'\').toLowerCase ());" style="width:99%;" />' . "\n";
												echo '<br /><small>* see: <code>API Scripting -> Custom Capabilities</code></small>' . "\n";
											}
									}
								else if ($page_id == $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"])
									echo 'This Page is your:<br /><strong>Membership Options Page</strong><br />( always publicly available )';
								/**/
								else if ($page_id == $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_welcome_page"])
									echo 'This Page is your:<br /><strong>Login Welcome Page</strong><br />( automatically guarded by s2Member )';
								/**/
								else if ($page_id == $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["file_download_limit_exceeded_page"])
									echo 'This Page is your:<br /><strong>Download Limit Exceeded Page</strong><br />( automatically guarded by s2Member )';
							}
						else /* Otherwise, we assume this is a Post, or possibly a Custom Post Type. It's NOT a Page. */
							{
								echo '<input type="hidden" name="ws_plugin__s2member_security_meta_box_save" id="ws-plugin--s2member-security-meta-box-save" value="' . esc_attr (wp_create_nonce ("ws-plugin--s2member-security-meta-box-save")) . '" />' . "\n";
								echo '<input type="hidden" name="ws_plugin__s2member_security_meta_box_save_id" id="ws-plugin--s2member-security-meta-box-save-id" value="' . esc_attr ($post_id) . '" />' . "\n";
								/**/
								$posts["0"] = preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level0_posts"]);
								$posts["1"] = preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_posts"]);
								$posts["2"] = preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_posts"]);
								$posts["3"] = preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_posts"]);
								$posts["4"] = preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_posts"]);
								/**/
								echo '<p style="margin-left:2px;"><strong>Post Level Restriction?</strong></p>' . "\n"; /* This allows a site owner to automatically add a Page/Post into their s2Member options. */
								echo '<label class="screen-reader-text" for="ws-plugin--s2member-security-meta-box-level">Add Level Restriction?</label>' . "\n";
								echo '<select name="ws_plugin__s2member_security_meta_box_level" id="ws-plugin--s2member-security-meta-box-level" style="width:99%;">' . "\n";
								echo '<option value=""></option>' . "\n"; /* By default, we allow public access to any Post/Page. */
								echo ($posts["0"] !== array ("all")) ? '<option value="0"' . ( (in_array ($post_id, $posts["0"])) ? ' selected="selected"' : '') . '>Require Level# 0 ( or higher )</option>' . "\n" : '<option value="" disabled="disabled">Level #0 ( already protects "all" Posts )</option>';
								echo ($posts["1"] !== array ("all")) ? '<option value="1"' . ( (in_array ($post_id, $posts["1"])) ? ' selected="selected"' : '') . '>Require Level# 1 ( or higher )</option>' . "\n" : '<option value="" disabled="disabled">Level #1 ( already protects "all" Posts )</option>';
								echo ($posts["2"] !== array ("all")) ? '<option value="2"' . ( (in_array ($post_id, $posts["2"])) ? ' selected="selected"' : '') . '>Require Level# 2 ( or higher )</option>' . "\n" : '<option value="" disabled="disabled">Level #2 ( already protects "all" Posts )</option>';
								echo ($posts["3"] !== array ("all")) ? '<option value="3"' . ( (in_array ($post_id, $posts["3"])) ? ' selected="selected"' : '') . '>Require Level# 3 ( or higher )</option>' . "\n" : '<option value="" disabled="disabled">Level #3 ( already protects "all" Posts )</option>';
								echo ($posts["4"] !== array ("all")) ? '<option value="4"' . ( (in_array ($post_id, $posts["4"])) ? ' selected="selected"' : '') . '>Require Level# 4 ( highest level )</option>' . "\n" : '<option value="" disabled="disabled">Level #4 ( already protects "all" Posts )</option>';
								echo '</select><br /><small>* see: <code>General Options -> Post Level Access</code></small>' . "\n";
								/**/
								if (!is_multisite () || !ws_plugin__s2member_is_multisite_farm () || is_main_site ())
									/* ^ Will change once Custom Capabilities are compatible with a Blog Farm. */
									{
										echo '<p style="margin-top:15px; margin-left:2px;"><strong>Require Custom Capabilities?</strong></p>' . "\n";
										echo '<label class="screen-reader-text" for="ws-plugin--s2member-security-meta-box-ccaps">Custom Capabilities?</label>' . "\n";
										echo '<input type="text" name="ws_plugin__s2member_security_meta_box_ccaps" id="ws-plugin--s2member-security-meta-box-ccaps" value="' . format_to_edit (implode (",", (array)get_post_meta ($post_id, "s2member_ccaps_req", true))) . '" onkeyup="if(this.value.match(/[^a-z_0-9,]/)) this.value = jQuery.trim (jQuery.trim (this.value).replace (/[ \-]/g, \'_\').replace (/[^A-Z_0-9,]/gi, \'\').toLowerCase ());" style="width:99%;" />' . "\n";
										echo '<br /><small>* see: <code>API Scripting -> Custom Capabilities</code></small>' . "\n";
									}
							}
					}
				/**/
				do_action ("ws_plugin__s2member_after_security_meta_box", get_defined_vars ());
				/**/
				return;
			}
	}
/*
Function save data entered into meta boxes,
	on Post/Page editing stations.
Attach to: add_action("save_post");
*/
if (!function_exists ("ws_plugin__s2member_save_meta_boxes"))
	{
		function ws_plugin__s2member_save_meta_boxes ($post_id = FALSE)
			{
				eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
				do_action ("ws_plugin__s2member_before_save_meta_boxes", get_defined_vars ());
				unset ($__refs, $__v); /* Unset defined __refs, __v. */
				/**/
				if ($post_id && ($nonce = $_POST["ws_plugin__s2member_security_meta_box_save"]) && wp_verify_nonce ($nonce, "ws-plugin--s2member-security-meta-box-save"))
					if ($post_id == $_POST["ws_plugin__s2member_security_meta_box_save_id"]) /* Do NOT process historical revisions. */
						/* We do NOT process historical revisions here; because it causes confusion in the General Options panel for s2Member. */
						{
							$_p = ws_plugin__s2member_trim_deep (stripslashes_deep ($_POST)); /* Clean up all _POST vars; making a local working copy of the array. */
							/**/
							if (($_p["post_type"] === "page" && current_user_can ("edit_page", $post_id)) || current_user_can ("edit_post", $post_id))
								{
									if ($_p["post_type"] === "page" && ($page_id = $post_id)) /* OK. So we're dealing with a Page classification. */
										{
											if (isset ($_p["ws_plugin__s2member_security_meta_box_level"])) /* Just needs to be set. It CAN be empty. */
												{
													$pages["0"] = array_unique (preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level0_pages"]));
													$pages["1"] = array_unique (preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_pages"]));
													$pages["2"] = array_unique (preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_pages"]));
													$pages["3"] = array_unique (preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_pages"]));
													$pages["4"] = array_unique (preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_pages"]));
													/**/
													if (($i = array_search ($page_id, $pages["0"])) !== false) /* Remove $page_id from existing options. */
														unset ($pages["0"][$i]);
													else if (($i = array_search ($page_id, $pages["1"])) !== false)
														unset ($pages["1"][$i]);
													else if (($i = array_search ($page_id, $pages["2"])) !== false)
														unset ($pages["2"][$i]);
													else if (($i = array_search ($page_id, $pages["3"])) !== false)
														unset ($pages["3"][$i]);
													else if (($i = array_search ($page_id, $pages["4"])) !== false)
														unset ($pages["4"][$i]);
													/**/
													if (strlen ($_p["ws_plugin__s2member_security_meta_box_level"]) && is_array ($pages[$_p["ws_plugin__s2member_security_meta_box_level"]]))
														if (!$pages[$_p["ws_plugin__s2member_security_meta_box_level"]] !== array ("all"))
															array_push ($pages[$_p["ws_plugin__s2member_security_meta_box_level"]], $page_id);
													/**/
													$new_options = array_merge ((array)$new_options, array ("ws_plugin__s2member_level0_pages" => implode (",", $pages[0]), "ws_plugin__s2member_level1_pages" => implode (",", $pages[1]), "ws_plugin__s2member_level2_pages" => implode (",", $pages[2]), "ws_plugin__s2member_level3_pages" => implode (",", $pages[3]), "ws_plugin__s2member_level4_pages" => implode (",", $pages[4])));
													/**/
													eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
													do_action ("ws_plugin__s2member_during_save_meta_boxes", get_defined_vars ());
													unset ($__refs, $__v); /* Unset defined __refs, __v. */
													/**/
													ws_plugin__s2member_update_all_options ($new_options, true, false, array ("page-conflict-warnings"), true);
												}
										}
									/**/
									else /* Otherwise, we assume this is a Post, or possibly a Custom Post Type. It's NOT a Page. */
										{
											if (isset ($_p["ws_plugin__s2member_security_meta_box_level"])) /* Just needs to be set. It CAN be empty. */
												{
													$posts["0"] = array_unique (preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level0_posts"]));
													$posts["1"] = array_unique (preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level1_posts"]));
													$posts["2"] = array_unique (preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level2_posts"]));
													$posts["3"] = array_unique (preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level3_posts"]));
													$posts["4"] = array_unique (preg_split ("/[\r\n\t\s;,]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level4_posts"]));
													/**/
													if (($i = array_search ($post_id, $posts["0"])) !== false) /* Remove $post_id from existing options. */
														unset ($posts["0"][$i]);
													else if (($i = array_search ($post_id, $posts["1"])) !== false)
														unset ($posts["1"][$i]);
													else if (($i = array_search ($post_id, $posts["2"])) !== false)
														unset ($posts["2"][$i]);
													else if (($i = array_search ($post_id, $posts["3"])) !== false)
														unset ($posts["3"][$i]);
													else if (($i = array_search ($post_id, $posts["4"])) !== false)
														unset ($posts["4"][$i]);
													/**/
													if (strlen ($_p["ws_plugin__s2member_security_meta_box_level"]) && is_array ($posts[$_p["ws_plugin__s2member_security_meta_box_level"]]))
														if (!$posts[$_p["ws_plugin__s2member_security_meta_box_level"]] !== array ("all"))
															array_push ($posts[$_p["ws_plugin__s2member_security_meta_box_level"]], $post_id);
													/**/
													$new_options = array_merge ((array)$new_options, array ("ws_plugin__s2member_level0_posts" => implode (",", $posts[0]), "ws_plugin__s2member_level1_posts" => implode (",", $posts[1]), "ws_plugin__s2member_level2_posts" => implode (",", $posts[2]), "ws_plugin__s2member_level3_posts" => implode (",", $posts[3]), "ws_plugin__s2member_level4_posts" => implode (",", $posts[4])));
													/**/
													eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
													do_action ("ws_plugin__s2member_during_save_meta_boxes", get_defined_vars ());
													unset ($__refs, $__v); /* Unset defined __refs, __v. */
													/**/
													ws_plugin__s2member_update_all_options ($new_options, true, false, array ("page-conflict-warnings"), true);
												}
										}
									/**/
									if ($_p["post_type"] === "page" && ($page_id = $post_id)) /* OK. So we're dealing with a Page classification. */
										{
											if (isset ($_p["ws_plugin__s2member_security_meta_box_ccaps"])) /* Just needs to be set. It CAN be empty. */
												{
													$ccaps_req = trim (strtolower ($_p["ws_plugin__s2member_security_meta_box_ccaps"]), ",");
													$ccaps_req = trim (preg_replace ("/[^a-z_0-9,]/", "", $ccaps_req), ","); /* Now clean up. */
													/**/
													if (strlen ($ccaps_req) && ($s2member_ccaps_req = preg_split ("/[\r\n\t\s;,]+/", $ccaps_req)))
														update_post_meta ($page_id, "s2member_ccaps_req", $s2member_ccaps_req);
													/**/
													else /* Otherwise, the array is empty. Safe to delete. */
														delete_post_meta ($page_id, "s2member_ccaps_req");
												}
										}
									/**/
									else /* Otherwise, we assume this is a Post, or possibly a Custom Post Type. It's NOT a Page. */
										{
											if (isset ($_p["ws_plugin__s2member_security_meta_box_ccaps"])) /* Just needs to be set. It CAN be empty. */
												{
													$ccaps_req = trim (strtolower ($_p["ws_plugin__s2member_security_meta_box_ccaps"]), ",");
													$ccaps_req = trim (preg_replace ("/[^a-z_0-9,]/", "", $ccaps_req), ","); /* Now clean up. */
													/**/
													if (strlen ($ccaps_req) && ($s2member_ccaps_req = preg_split ("/[\r\n\t\s;,]+/", $ccaps_req)))
														update_post_meta ($post_id, "s2member_ccaps_req", $s2member_ccaps_req);
													/**/
													else /* Otherwise, the array is empty. Safe to delete. */
														delete_post_meta ($post_id, "s2member_ccaps_req");
												}
										}
								}
						}
				/**/
				do_action ("ws_plugin__s2member_after_save_meta_boxes", get_defined_vars ());
				/**/
				return;
			}
	}
?>