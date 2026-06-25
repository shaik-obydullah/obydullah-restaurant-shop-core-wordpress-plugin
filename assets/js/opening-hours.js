/**
 * Opening Hours Admin Script
 *
 * @package Obydullah_Restaurant_Shop_Core
 * @since   1.0.0
 * @author  Shaik Obydullah
 *
 * Handles the opening hours repeater:
 * - Add new hour rows
 * - Remove existing rows
 * Uses localised strings from obirsc_opening_hours.
 */

jQuery(document).ready(function ($) {
  $("#obirsc-add-hours-row").on("click", function () {
    var newRow =
      '<div class="obirsc-hours-row">' +
      '<input type="text" name="obirsc_hours_day[]" class="obirsc-hours-day" placeholder="' +
      obirsc_opening_hours.dayPlaceholder +
      '">' +
      '<input type="text" name="obirsc_hours_time[]" class="obirsc-hours-time" placeholder="' +
      obirsc_opening_hours.timePlaceholder +
      '">' +
      '<button type="button" class="button obirsc-remove-row">' +
      obirsc_opening_hours.removeText +
      "</button>" +
      "</div>";
    $("#obirsc-hours-repeater").append(newRow);
  });
  $(document).on("click", ".obirsc-remove-row", function () {
    $(this).closest(".obirsc-hours-row").remove();
  });
});
