$(document).ready(function(){

var countries = [
    { Name: "", Id: 0 },
    { Name: "United States", Id: 1 },
    { Name: "Canada", Id: 2 },
    { Name: "United Kingdom", Id: 3 }
];
    console.log(beers);
    console.log(brewers);

$("#jsGrid").jsGrid({
    width: "100%",
    height: "400px",

    inserting: true,
    sorting: true,
    paging: true,
    gridview: true,
    pageSize: 25,

    controller: {
        loadData: function(filter) {
            var d = $.Deferred();

            console.log(d);

            // server-side filtering
            $.ajax({
                type: "GET",
                url: "/beers",
                data: filter,
                dataType: "json"
            }).done(function(result) {
                // client-side filtering
                result = $.grep(result, function(item) {
                    return item.SomeField === filter.SomeField;
                });

                d.resolve(result);
            })

            return d.promise();
        }
    },

    data: beers,

    fields: [
        { name: "brewer", type: "select", items: brewers, valueField: "brewerId", textField: "brewerName", width: 100  },
        {
            name: "name",
            type: "text",
            width: 100
        },
        { name: "price", type: "text", width: 50 },
        { name: "country", type: "select", items: countries, valueField: "Id", textField: "Name" },
        { name: "type", type: "text", width: 200,}
    ]
});

});
