<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<?php

/**
	 * Adds a new event to the database.
	 *
	 * @param string $title		title of the event.
	 * @param string $location	location of the event.
	 * @param string $linkout	either a user provided URL or a link to the
	 * 				associated post if a post was published.
	 * @param string $startDate 	starting date of the event.
	 * @param string $startTime	starting time of the event. Optional.
	 * @param string $endDate	ending date of the event. If not provided, ewill be
	 *				the same as starting date.
	 * @param string $endTime	ending time of the event. 
	 * @param int    $accessLevel	who can access this event.
	 * @param int    $postID	associated post id if available.
	 */
	function addEvent($user_id, $title, $location, $eventType, $linkout, $description, $startDate, $startTime, $endDate, $endTime, $accessLevel, $postID) {
			$current_user = wp_get_current_user();
		$this->db->addEvent($current_user->ID, $title, $location, $eventType, $linkout, $description, $startDate, $startTime, $endDate, $endTime, $accessLevel, $postID);
		return;
	}
/**
	 * Outputs the Add Event form.
	 *
	 * Provides the HTML and Javascript necessary for the user to add and validate a new event.
	 */
	function addEventForm() {
?>
	<a name="addEventform"></a><h2><?php _e('Add Event','events-calendar'); ?></h2>
    <form name="EC_addEventForm" method="post" action="?page=events-calendar" onSubmit="return valid_addEventForm();" onClick='jQuery("#EC_alertmsg").fadeOut("slow");'>
      <p class="submit">
        <input type="submit" name="submit" value="<?php _e('Add Event','events-calendar'); ?> &raquo;">
      </p>
    <div id="EC_alertmsg" class="alertmsg">
      <img id="EC_close_message_alert" src="<?php echo EVENTSCALENDARIMAGESURL."/cross.png";?>" />
      <img id="ec-alert-img" src="<?php echo EVENTSCALENDARIMAGESURL."/alert.png";?>" /> <strong><?php _e('Warning','events-calendar'); ?></strong>
      <p>message</p>
    </div>
      <table border ="0" id="EC_management-add-form" summary="Event Add Form" class="ec-edit-form">
        <tr>
          <th scope="row"><label for="title"><?php _e('Title','events-calendar'); ?></label></th>
          <td><input class="ec-edit-form-text" type="text" name="EC_title" id="EC_title" value=" <?php echo $user; ?>"/></td>
        </tr>
        <tr>
          <th scope="row"><label for="location"><?php _e('Location','events-calendar'); ?></label></th>
          <td><input class="ec-edit-form-text" type="text" name="EC_location" id="EC_location" /></td>
        </tr>
        <tr>
          <th scope="row"><label for="linkout"><?php _e('Link out','events-calendar'); ?></label></th>
          <td><input class="ec-edit-form-text" type="text" name="EC_linkout" id="EC_linkout" value="<?php echo $this->deflinkout;?>"/></td>
        </tr>
        <tr>
          <th scope="row" valign="top"><label for="description"><?php _e('Description','events-calendar'); ?></label></th>
          <td><textarea class="ec-edit-form-textarea" name="EC_description" id="EC_description"></textarea></td>
        </tr>
        <?phP
			$filterList = apply_filters('EC_EventsTypes', array());
		?>
        <tr>
          <th scope="row"><label for="linkout"><?php _e('Type','events-calendar'); ?></label></th>
          <td><select class="ec-edit-form-type" type="text" name="EC_type" id="EC_type">
          <?php
		  	foreach ($filterList as $keyfL => $fL) 
			{
    			?> <option value = "<?php print $keyfL; ?>" > <?php print $fL; ?> </option> <?php
			}
		  ?>
          </select></td>
          		
        </tr>
        <tr>
          <th scope="row"><label for="startDate"><?php _e('Start Date (YYYY-MM-DD, if blank will be today)','events-calendar'); ?></label></th>
          <td><input class="ec-edit-form-date" autocomplete="OFF" type="text" name="EC_startDate" id="EC_startDate" /></td>
        </tr>
        <tr>
          <th scope="row"><label for="startTime"><?php _e('Start Time (HH:MM, can be blank)','events-calendar'); ?></label></th>
          <td><input class="ec-edit-form-time" autocomplete="OFF" type="text" name="EC_startTime" id="EC_startTime" /><img src="<?php echo EVENTSCALENDARIMAGESURL."/time.png";?>" id="EC_start_clockpick" onClick='jQuery("#EC_alertmsg").fadeOut("slow");'></td>
        </tr>
        <tr>
          <th scope="row"><label for="endDate"><?php _e('End Date (YYYY-MM-DD, if blank will be same as start date)','events-calendar'); ?></label></th>
          <td><input class="ec-edit-form-date" autocomplete="OFF" type="text" name="EC_endDate" id="EC_endDate" /></td>
        </tr>
        <tr>
          <th scope="row"><label for="endTime"><?php _e('End Time (HH:MM, can be blank)','events-calendar'); ?></label></th>
          <td><input class="ec-edit-form-time" autocomplete="OFF" type="text" name="EC_endTime" id="EC_endTime" /><img src="<?php echo EVENTSCALENDARIMAGESURL."/time.png";?>" id="EC_end_clockpick" onClick='jQuery("#EC_alertmsg").fadeOut("slow");'></td>
        </tr>
        <tr>
          <th scope="row"><label for="endTime"><?php _e('Visibility Level','events-calendar'); ?></label></th>
          <td>
            <select name="EC_accessLevel" id="EC_accessLevel">
              <option value="public"><?php _e('Public','events-calendar'); ?></option>
              <option value="level_10"><?php _e('Administrator','events-calendar'); ?></option>
              <option value="level_7"><?php _e('Editor','events-calendar'); ?></option>
              <option value="level_2"><?php _e('Author','events-calendar'); ?></option>
              <option value="level_1"><?php _e('Contributor','events-calendar'); ?></option>
              <option value="level_0"><?php _e('Subscriber','events-calendar'); ?></option>
            </select>
          </td>
        </tr>
        <tr>
          <th scope="row"><label for="doPost"><?php _e('Create Post for Event','events-calendar'); ?></label></th>
          <td><input type="checkbox" name="EC_doPost" id="EC_doPost"/></td>
        </tr>
      </table>
      <span id="showSelectStatusPost">
      <table id="EC_management-post-status" summary="Event Post Status" class="ec-edit-form" width="100%" cellspacing="2" cellpadding="5">
        <tr>
          <th scope="row"><label for="statusPost"><?php _e('Which Post Status ?','events-calendar'); ?></label></th>
          <td>
            <select name="EC_statusPost" id="EC_statusPost">
              <option value="draft" selected="selected" ><?php _e('Draft','events-calendar'); ?></option>
              <option value="publish" ><?php _e('Publish','events-calendar'); ?></option>
            </select>
          </td>
        </tr>
      </table>
      </span>
      <input type="hidden" name="EC_addEventFormSubmitted" value="1" />
      <p class="submit">
        <input type="submit" name="submit" value="<?php _e('Add Event','events-calendar'); ?> &raquo;">
      </p>
    </form>
    <script language="javascript">
    // <![CDATA[
      function ec_parse_float(valtime) {
// var idx = valtime.indexOf(":");
        var hr = valtime.substr(0,2);
        var mm = valtime.substr(3,2);
        return parseFloat(hr+"."+mm);
      }
      function valid_addEventForm() {
        if (document.forms.EC_addEventForm.EC_title.value=="") {
          alertmsgbox("<?php _e('Event Title can not be blank!','events-calendar'); ?>");
          document.forms.EC_addEventForm.EC_title.focus();
          return false;
        }
			
        var stt = ec_parse_float(document.forms.EC_addEventForm.EC_startTime.value);
		  var edt = ec_parse_float(document.forms.EC_addEventForm.EC_endTime.value);
		  var startDt =            document.forms.EC_addEventForm.EC_startDate.value;
		  var endDt =              document.forms.EC_addEventForm.EC_endDate.value;

		  if (endDt == null || endDt == undefined || endDt == '')
				endDt = startDt;

        if (endDt < startDt) {
			  alertmsgbox("<?php _e('The end date is earlier than the start date.', 'events-calendar');?>");
			  document.forms.EC_addEventForm.EC_endDate.focus();
           return false;
		  }

        if (startDt == endDt && edt < stt) {
          alertmsgbox("<?php _e('The end time is earlier than the start time ;-)','events-calendar'); ?>");
          document.forms.EC_addEventForm.EC_endTime.focus();
          return false;
        }
      }
      //jQuery.noConflict();
      function alertmsgbox(msg) {
        jQuery("#EC_alertmsg p").text(msg);
        jQuery("#EC_alertmsg").show();
        jQuery("#EC_alertmsg").animate({ top: "885px" }, 0 ).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100);
      }
      jQuery("form[name='EC_addEventForm']").ready(function(){
          if (jQuery("#EC_doPost").is(":checked")) {
            jQuery("#showSelectStatusPost").show("slow");
          } else {
            jQuery("#showSelectStatusPost").hide("slow");
          }
      });
      jQuery("#EC_doPost").click(function(){
          if (jQuery("#EC_doPost").is(":checked")) {
            jQuery("#showSelectStatusPost").show("slow");
          } else {
            jQuery("#showSelectStatusPost").hide("slow");
          }
      });
      jQuery(document).ready(function() {
          jQuery("#EC_close_message_alert").click(function() {
              jQuery("#EC_alertmsg").fadeOut("slow");
          });
          jQuery("#EC_alertmsg").hide();
      });
    //]]>
    </script>




</body>
</html>
