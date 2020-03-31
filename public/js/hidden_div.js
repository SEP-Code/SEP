document.getElementById('test').addEventListener('change', function () {
    var style1 = this.value == 1 ? 'block' : 'none';
    var style2 = this.value == 2 ? 'block' : 'none';
    var style3 = this.value == 3 ? 'block' : 'none';
    document.getElementById('div1').style.display = style1;
    document.getElementById('div2').style.display = style2;
    document.getElementById('div3').style.display = style3;
});
