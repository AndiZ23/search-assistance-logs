/*
    get pid and tid of the event
 */
function getIDs() {
    pid = $("input[name='pid']").attr("value");
    tid = $("input[name='tid']").attr("value");
    return [pid, tid];
}

function getQuery() {
    query = $("input[name='query']").val();
    return query;
}

/*
    Output function
 */
function writeLog(pid, tid, query, etype, etarget, edesc, timestamp) {
    $("#showlogs small").html("<table>" +
        "<tr><th>Participant id</th><td>"+ pid +"</td></tr>" +
        "<tr><th>Task id</th><td>"+ tid +"</td></tr>" +
        "<tr><th>Current Query</th><td>"+ query +"</td></tr>" +
        "<tr><th>Event</th><td>"+ etype +"</td></tr>" +
        "<tr><th>Target</th><td>"+ etarget +"</td></tr>" +
        "<tr><th>Event Description:</th><td>"+ edesc +"</td></tr>" +
        "<tr><th>Timestamp</th><td>"+ timestamp +"</td></tr></table>");
}

function writeLog2db(pid, tid, query, etype, etarget, edesc, timestamp) {
    $.post("writeLogs2db.php",
        {
            PID: pid,
            TID: tid,
            QUERY: query,
            ETYPE: etype,
            ETARGET: etarget,
            EDESC: edesc,
            TSTAMP: timestamp
        });
}

/*
    Call when the search query is submitted.
 */
function SearchSubmit(pid, tid, etype) {
    /*
        call when every query is submitted,
        record text content of the input box and timestamp of submitting
     */
    query = getQuery();
    target = ".searchbox";
    edesc = "Submit a new query";
    timestamp = new Date().getTime();

    writeLog(pid, tid, query, etype, target, edesc, timestamp);
    writeLog2db(pid, tid, query,etype,target, edesc, timestamp);
}



$(document).ready(function () {

    ids = getIDs();
    pid = ids[0]; tid = ids[1];

    /*
        typing on the search input box
     */
    $("input[name='query']").keydown(function (event) {
        /*
            If it's not the "enter" key (aka. code 13), record key pressed and timestamp
         */
        if (event.which != 13) {
            target = ".searchbox input[name='query']";
            edesc = "Typing query. Key: [" + event.key +"].";
            timestamp = new Date().getTime();

            writeLog(pid, tid, "---", "typing", target, edesc, timestamp);
            writeLog2db(pid, tid, "---", "typing",target, edesc, timestamp);
        }
        /*
            Else, trigger the function of SearchSubmit()
         */
        else {
            SearchSubmit(pid, tid, "keydown: [Enter]");
        }
    });

    /*
        Click the "Search" button of the search box
     */
    $("input[type='submit']").click(function () {
        SearchSubmit(pid, tid, "click on 'Submit'");
    });

    /*
        Mouse events
        Enter and leave the assistant widget: hide or show the suggestions; log the movement.
     */
    $(".assistant").mouseenter(function () {
        $(".assistant-cover").css({"visibility": "hidden"});
        query = getQuery();
        target = ".assistant";
        edesc = "Mouse enters .assistant widget";
        timestamp = new Date().getTime();
        writeLog(pid, tid, query, "mouseenter", target, edesc, timestamp);
        writeLog2db(pid, tid, query, "mouseenter",target, edesc, timestamp);
    });
    $(".assistant").mouseleave(function() {
        $(".assistant-cover").css({"visibility": "visible"});
        query = getQuery();
        target = ".assistant";
        edesc = "Mouse leaves .assistant widget";
        timestamp = new Date().getTime();
        writeLog(pid, tid, query, "mouseleave", target, edesc, timestamp);
        writeLog2db(pid, tid, query, "mouseleave",target, edesc, timestamp);
    });

    /*
        Mouse moving around assistance items: mouseenter, click
     */

    $("ol li a").mouseenter(function() {
        suggest = $(this).text();
        query = getQuery();
        edesc = 'hovering on suggested method/dimension';
        timestamp = new Date().getTime();
        writeLog2db(pid, tid, query, 'mouseenter', 'method/dimension', edesc, timestamp);

        /*
            attach suggested method/dimension when click
         */
        $(this).click(function(){
            query = query+' '+suggest;
            $("input[name='query']").val(query);
            edesc = 'click/submit new query through assistance';
            timestamp = new Date().getTime();
            writeLog2db(pid, tid, query, 'click', 'method/dimension', edesc, timestamp);
            $("form#searchform").submit();
        });
    });

    $(".suggest-links").mouseenter(function() {
       query = getQuery();
       title = $("b a", this).text();
       url = $('b a',this).attr('href');
       target = 'assistance\'s links';
       edesc = "Mouse enters assistance link item: \n" +
           "Title: "+title+";\n"+
           "URL: "+url;
       timestamp = new Date().getTime();
       writeLog2db(pid,tid,query,'mouseenter',target,edesc,timestamp);

       $('b a', this).click(function(){
           edesc = "Click on assistance link item: \n" +
               "Title: "+title+";\n"+
               "URL: "+url;
           timestamp = new Date().getTime();
           writeLog2db(pid, tid, query, 'click', target, edesc, timestamp);
       });
    });

    /*
        Mouse moving around search results: mouseenter, click
        Get $title and $url of each hovered result item
     */
    $(".result-item").mouseenter(function () {
        rid = $(this).attr("id");
        query = getQuery();
        title = $(".title a", this).text();
        url = $(".link", this).text();
        target = ".result-item rid:" + rid;
        edesc = "Mouse enters result item: \n" +
            "Title: " + title + ";\n" +
            "URL: " + url;
        timestamp = new Date().getTime();
        writeLog(pid, tid, query, "mouseenter", target, edesc, timestamp);
        writeLog2db(pid, tid, query, "mouseenter", target, edesc, timestamp);

        $(".title a", this).click(function () {
            edesc = "Click on result item: \n" +
                "Title: " + title + ";\n" +
                "URL: " + url;
            timestamp = new Date().getTime();
            writeLog(pid, tid, query, "click on result", target, edesc, timestamp);
            writeLog2db(pid, tid, query, "click on result", target, edesc, timestamp);
        });
    });


});