/**
 * Footer Settings Admin Script
 *
 * @package Obydullah_Restaurant_Shop_Core
 * @since   1.0.0
 * @author  Shaik Obydullah
 *
 * Handles the footer quick links repeater:
 * - Add new link rows
 * - Remove existing rows
 * Uses localised strings from obirscFooterL10n.
 */

jQuery(document).ready(function ($) {
  // Add new link row using the hidden counter
  $("#obirsc-add-footer-link").on("click", function () {
    var counter = $("#obirsc-footer-link-count");
    var newIndex = parseInt(counter.val());
    var newRow =
      '<div class="obirsc-footer-link-row obirsc-repeater-row" data-index="' +
      newIndex +
      '">' +
      '<input type="text" name="obirsc_footer_links[' +
      newIndex +
      '][text]" class="obirsc-link-text" placeholder="' +
      obirscFooterL10n.linkTextPlaceholder +
      '">' +
      '<input type="text" name="obirsc_footer_links[' +
      newIndex +
      '][url]" class="obirsc-link-url" placeholder="' +
      obirscFooterL10n.urlPlaceholder +
      '">' +
      '<button type="button" class="button obirsc-remove-row">' +
      obirscFooterL10n.removeText +
      "</button>" +
      "</div>";
    $("#obirsc-footer-links-repeater").append(newRow);
    counter.val(newIndex + 1);
  });

  // Remove row
  $(document).on("click", ".obirsc-remove-row", function () {
    $(this).closest(".obirsc-footer-link-row").remove();
  });
});
