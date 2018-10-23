$(document).ready(function(){

var countries = [
    { Name: "", Id: 0 },
    { Name: "United States", Id: 1 },
    { Name: "Canada", Id: 2 },
    { Name: "United Kingdom", Id: 3 }
];
    console.log(clients);
    console.log(countries);

$("#jsGrid").jsGrid({
    width: "100%",
    height: "400px",

    inserting: true,
    sorting: true,
    paging: true,


    data: clients,

    fields: [
        { name: "brewer", type: "text", width: 200, validate: "required" },
        { name: "name", type: "text", width: 200 },
        { name: "price", type: "text", width: 50 },
        { name: "country", type: "select", items: countries, valueField: "Id", textField: "Name" },
        { name: "type", type: "text", width: 200,}
    ]
});

});
