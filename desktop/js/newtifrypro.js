function addCmdToTable(_cmd) {
  if (!isset(_cmd)) {
    var _cmd = {
      configuration: {}
    };
  }
  var tr = '<tr class="cmd" data-cmd_id="' + init(_cmd.id) + '">';
  tr += '<td>';
  tr += '<input class="cmdAttr form-control input-sm" data-l1key="id" style="display : none;">';
  tr += '<input class="cmdAttr form-control input-sm" data-l1key="name"></td>';
  tr += '<td><input class="cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="devid"></td>';
  tr += '<td>';
  tr += '<input class="cmdAttr form-control input-sm" data-l1key="type" value="action" style="display : none;">';
  tr += '<input class="cmdAttr form-control input-sm" data-l1key="subType" value="message" style="display : none;">';
  if (is_numeric(_cmd.id)) {
    tr += '<a class="btn btn-default btn-xs cmdAction expertModeVisible" data-action="configure"><i class="fa fa-cogs"></i></a> ';
    tr += '<a class="btn btn-default btn-xs cmdAction" data-action="test"><i class="fa fa-rss"></i> {{Tester}}</a>';    
  }
  tr += '<i class="fa fa-minus-circle pull-right cmdAction cursor" data-action="remove"></i></td>';
  tr += '</tr>';
  $('#table_cmd tbody').append(tr);
  $('#table_cmd tbody tr:last').setValues(_cmd, '.cmdAttr');
}