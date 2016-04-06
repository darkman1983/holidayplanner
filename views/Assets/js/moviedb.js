$('#hiddenTip').hide();
$('#tips').click(function() {
	if ($('#hiddenTip').is(':visible')) {
		$('#hiddenTip').hide(1000);
	} else {
		$('#hiddenTip').show(1000);
	}
});