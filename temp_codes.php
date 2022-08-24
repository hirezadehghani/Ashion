<script>
    let combination_str = '';
    var form = document.getElementById("combination_form");
    form.addEventListener("submit", setCombination_string);

    function setCombination_string() {
        var selects = $('.specific-id');
        var length = selects.length;
        for (let index = 0; index < selects.length; index++) {
            combination_str += selects[index].value;
        }
        document.getElementById("combination_input").value = combination_str;
    }
</script>

//SET and sort combination string
$combination_string = $_GET['combination_string'];
$combination_string = str_split($combination_string);
sort($combination_string);
$combination_string = implode($combination_string);