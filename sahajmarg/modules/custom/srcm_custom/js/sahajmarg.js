(function ($) {
  
Drupal.behaviors.StateCityFilter = {
  attach: function (context, settings) {
  	state_city_json = $('.field--name-field-state-and-centre .form-item-field-state-and-centre-0-value input[name="field_state_and_centre[0][value]"]');
  	if (!$('.state-select-list').length) {
  		$("#state-select-list-on-country").append('<label for="state-field">State</label><select id="state-field" class="state-select-list"><option value="_none">- None -</option></select>');
  	} 
  	if (!$('.centre-select-list').length) {
  		$("#centre-select-list-on-state").append('<label for="centre-field">Centre</label><select id="centre-field" class="centre-select-list"><option value="_none">- None -</option></select>');
  	}
  	var sel_state_city = {};
  	var centre_id = '_none';
  	if (state_city_json.val().length) {
  		var json_state_city = JSON.parse(state_city_json.val());
  		
  		if (typeof json_state_city.state.id !== 'undefined') {
  			sel_state_city['state'] = {};
  			sel_state_city['state']['id'] = json_state_city.state.id;
  		  sel_state_city['state']['name'] = json_state_city.state.name;
  		}
  		if (typeof json_state_city.centre !== 'undefined' && typeof json_state_city.centre.id !== 'undefined') {
  			sel_state_city['centre'] = {};
  			sel_state_city['centre']['id'] = json_state_city.centre.id;
  			sel_state_city['centre']['name'] = json_state_city.centre.name;
  			centre_id = json_state_city.centre.id;
  		}
  		
  		state_reload_country_change(json_state_city.state.id,$('select[name="field_country"]').val());
  		centre_reload_state_change(centre_id,json_state_city.state.id)
  	} else {
  		state_reload_country_change('_none',$('select[name="field_country"]').val());
  	}
  	
  	$('select[name="field_country"]').change(function() {
  		state_reload_country_change('_none',$(this).val());
  		sel_state_city = {};
  		state_city_json.val('');
		});
		$('select.state-select-list').change(function() {
			var state_val = $('select.state-select-list').val();
			centre_reload_state_change('_none',state_val);
			if ($('select.state-select-list').val() != '_none') {
				sel_state_city['state'] = {};
				sel_state_city['state']['id'] = $(this).val();
	  		sel_state_city['state']['name'] = $('select.state-select-list option[value='+$(this).val()+']').text();
	  		state_city_json.val(JSON.stringify(sel_state_city));
  	  } else {
  	  	sel_state_city = {};
				state_city_json.val('');
  	  }
		});
    $('select.centre-select-list').change(function() {
			if ($('select.centre-select-list').val() != '_none') {
				sel_state_city['centre'] = {};
				sel_state_city['centre']['id'] = $(this).val();
	  		sel_state_city['centre']['name'] = $('select.centre-select-list option[value='+$(this).val()+']').text();
	  		state_city_json.val(JSON.stringify(sel_state_city));
			} else {
				sel_state_city['centre'] = {};
				state_city_json.val(JSON.stringify(sel_state_city));
			}
		});
    function state_reload_country_change(state_val,country_val) {
    	$('select.state-select-list').find('option').remove();
    	$('select.centre-select-list').find('option').remove();
    	$('select.centre-select-list').append($("<option></option>").attr("value",'_none').text('- None -'));
  		$.getJSON('/get_state_city/states/'+country_val,function(data){
			  $.each( data, function( key, val ) {
			    $('select.state-select-list').append($("<option></option>").attr("value",key).text(val)); 
			  });
			  $('select.state-select-list option[value="'+state_val+'"]').attr('selected', 'selected');
			  if (state_val != '_none') {

			  }
			  var select = $('select.state-select-list');
				select.find('option[value="_none"]').insertBefore(select.find('option:eq(0)'));
		  });
    }
    function centre_reload_state_change(centre_val,state_val) {
  		$('select.centre-select-list').find('option').remove();
		  $.getJSON('/get_state_city/cities/'+state_val,function(data){
			  $.each( data, function( key, val ) {
			    $('select.centre-select-list').append($("<option></option>").attr("value",key).text(val)); 
			  });
			  $('select.centre-select-list [value="'+centre_val+'"]').attr('selected', 'selected');
			  if (centre_val != '_none') {
			  }
			  var select = $('select.centre-select-list');
				select.find('option[value="_none"]').insertBefore(select.find('option:eq(0)'));
		  });
    }
  }
}

})(jQuery);
