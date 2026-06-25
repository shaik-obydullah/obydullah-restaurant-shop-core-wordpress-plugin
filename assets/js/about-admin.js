/**
 * About Page Admin Script
 *
 * @package Obydullah_Restaurant_Shop_Core
 * @since   1.0.0
 * @author  Shaik Obydullah
 *
 * Handles the about page slider repeater:
 * - Add new slide rows
 * - Remove slide rows
 * - WordPress media uploader for images
 * - Toggle remove button visibility via CSS class
 */

jQuery(document).ready(function ($) {
  var slideCounter = parseInt($("#obirsc-about-slide-count").val()) || 0;

  $("#obirsc-add-about-slide").on("click", function () {
    var newIndex = slideCounter;
    var newRow = `
      <div class="obirsc-slide-row" data-index="${newIndex}">
        <p>
          <label>${obirscAboutL10n.titlePlaceholder}</label><br>
          <input type="text" name="obirsc_about_slides[${newIndex}][title]" class="widefat">
        </p>
        <p>
          <label>${obirscAboutL10n.subtitlePlaceholder}</label><br>
          <input type="text" name="obirsc_about_slides[${newIndex}][subtitle]" class="widefat">
        </p>
        <div class="slide-image-wrapper">
          <label>${obirscAboutL10n.imagePlaceholder}</label><br>
          <input type="hidden" name="obirsc_about_slides[${newIndex}][image]" class="slide-image-url">
          <div class="image-preview"></div>
          <button type="button" class="button select-slide-image">${obirscAboutL10n.selectImage}</button>
          <button type="button" class="button remove-slide-image hidden">${obirscAboutL10n.removeImage}</button>
        </div>
        <button type="button" class="button obirsc-remove-slide-row">${obirscAboutL10n.removeText}</button>
      </div>
    `;
    $("#obirsc-about-slides-repeater").append(newRow);
    slideCounter++;
    $("#obirsc-about-slide-count").val(slideCounter);
  });

  $(document).on("click", ".obirsc-remove-slide-row", function () {
    $(this).closest(".obirsc-slide-row").remove();
    reindexSlides();
  });

  function reindexSlides() {
    var newCounter = 0;
    $("#obirsc-about-slides-repeater .obirsc-slide-row").each(function (index) {
      $(this).attr("data-index", index);
      $(this)
        .find('input[name*="[title]"]')
        .attr("name", "obirsc_about_slides[" + index + "][title]");
      $(this)
        .find('input[name*="[subtitle]"]')
        .attr("name", "obirsc_about_slides[" + index + "][subtitle]");
      $(this)
        .find('input[name*="[image]"]')
        .attr("name", "obirsc_about_slides[" + index + "][image]");
      newCounter = index + 1;
    });
    $("#obirsc-about-slide-count").val(newCounter);
    slideCounter = newCounter;
  }

  $(document).on("click", ".select-slide-image", function (e) {
    e.preventDefault();
    var button = $(this);
    var wrapper = button.closest(".slide-image-wrapper");

    var frame = wp.media({
      title: obirscAboutL10n.selectImage,
      button: { text: obirscAboutL10n.selectImage },
      multiple: false,
    });

    frame.on("select", function () {
      var attachment = frame.state().get("selection").first().toJSON();
      wrapper.find(".slide-image-url").val(attachment.url);
      wrapper
        .find(".image-preview")
        .html(
          '<img src="' + encodeURI(attachment.url) + '" class="preview-thumb">',
        );
      wrapper.find(".remove-slide-image").removeClass("hidden");
    });

    frame.open();
  });

  // Remove image
  $(document).on("click", ".remove-slide-image", function (e) {
    e.preventDefault();
    var wrapper = $(this).closest(".slide-image-wrapper");
    wrapper.find(".slide-image-url").val("");
    wrapper.find(".image-preview").empty();
    $(this).addClass("hidden");
  });
});
