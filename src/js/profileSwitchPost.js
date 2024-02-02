$(document).ready(function () {
    // Initially hide all sections except the postSection
    $('#taggedSection, #savedSection').hide();

    // Function to switch between tabs
    function switchTab(tabId) {
        $('#postSection, #taggedSection, #savedSection').hide();
        $('#' + tabId).show().css('display', 'grid'); // Set display property to grid
    }

    // Click event for the Post tab
    $('#postSectionBtn').on('click', function () {
        switchTab('postSection');
    });

    // Click event for the Tagged tab
    $('#taggedSectionBtn').on('click', function () {
        switchTab('taggedSection');
    });

    // Click event for the Saved tab
    $('#savedSectionBtn').on('click', function () {
        switchTab('savedSection');
    });
});
