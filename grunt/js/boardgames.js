$(document).ready(function(){
    $('#addBG').submit(function() {
        event.preventDefault();
        
        $('#results table tbody tr').remove();
        
        if ($('#BggId').val() != '') {
            window.location = base_url + 'boardgames/add/' + $('#BggId').val();
            return;
        }
        
        var url = $(this).attr('action');
        var postdata = $(this).serialize();
        $('#results-loading').show();
        $.post(url, postdata).done(function(data) {
            for (var i = 0; i < data['Bgg']['items']['@total']; i++) {
                var item = data['Bgg']['items']['item'][i];
                var row = $('<tr> \
                    <td><img src="' + base_url + 'boardgames/bggthumbnail/' + item['@id'] + '" alt="" /></td> \
                    <td>' + item['@id'] + '</td> \
                    <td>' + item['name']['@value'] + '</td> \
                    <td>' + ((item['yearpublished']) ? item['yearpublished']['@value'] : '') + '</td> \
                    <td><a href="' + base_url + 'boardgames/add/' + item['@id'] +'" class="btn btn-primary btn-xs">Add</a></td> \
                </tr>');
                $('#results table tbody').append(row);
                $('#results').show();
            }
            $('#results-loading').hide();
        });
    });
});