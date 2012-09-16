function addOneOption(attrId, button)
{
    var tr;
    var htmlToAdd;

    tr = button.up().up();
    htmlToAdd = '<tr><td>&nbsp;</td><td><input type="text" class="input-text" name="new_value['+attrId+']" />' +
        '<a href="#" onclick="removeOption(this);return false;">Remove</a></td></tr>';
    tr.insert({after:htmlToAdd});
}
function removeOption(anchor)
{
    var tr;

    tr = anchor.up().up();
    tr.remove();
}