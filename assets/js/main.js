jQuery( function( $ ) {

    const igj_jobs = {
        $job_section: $('.igj_jobs'),
        $pagination_section: $('.igj_pagination'),
        page: 1,
        length: 10,
        jobsTotal: 0,
        state: 'all',
        city: 'all',
        $cities: $('#igj_cities'),
        $states: $('#igj_states'),
        init: function () {

            this.getJobs(10, 0, 1);
            $('.igj_pagination').on('click', '.page-item', this.pageNavigation);

            this.$states.on('change', this.getJobs);
            this.$cities.on('change', this.getJobs);

        },
        pageNavigation: function(e){
            let page = $(this).data('page');
            igj_jobs.page = page;
            igj_jobs.getJobs();
        },
        pagination: function(){

            igj_jobs.$pagination_section.empty();

            let totalPages = Math.ceil(parseInt(igj_jobs.jobsTotal)/parseInt(igj_jobs.length));

            for(let i = 1; i <= totalPages; i++){
                let active =  i === parseInt(igj_jobs.page) ? 'active' : '';
                igj_jobs.$pagination_section.append('<li data-page="'+ i +'" class="page-item ' + active + ' page-' + i +'"><span class="page-link">' + i +'</span></li>');
            }

        },
        getJobs: function () {

            $.ajax({
                type: 'POST',
                url: parameters.ajax_url,
                data: {
                    'action': 'igj_get_jobs',
                    'length': igj_jobs.length,
                    'page': igj_jobs.page,
                    'city': $('#igj_cities').val(),
                    'state': $('#igj_states').val(),
                },
                dataType: "json",
                beforeSend: function () {
                    igj_jobs.$job_section.empty().append('<h5 class="text-center">Loading...</h5>');
                },
                complete: function () {
                },
                success: function (response) {

                    if (response.success) {

                        igj_jobs.$job_section.empty().append(response.jobs);
                        igj_jobs.jobsTotal = response.totalJobs;
                        igj_jobs.page = response.page;
                        igj_jobs.length = response.length;
                        igj_jobs.pagination();

                    } else {
                        alert("There was an error, please try again!");
                    }

                },
                error: function (jqXHR, exception) {
                    var msg = '';
                    if (jqXHR.status === 0) {
                        msg = 'Not connect.\n Verify Network.';
                    } else if (jqXHR.status == 404) {
                        msg = 'Requested page not found. [404]';
                    } else if (jqXHR.status == 500) {
                        msg = 'Internal Server Error [500].';
                    } else if (exception === 'parsererror') {
                        msg = 'Requested JSON parse failed.';
                    } else if (exception === 'timeout') {
                        msg = 'Time out error.';
                    } else if (exception === 'abort') {
                        msg = 'Ajax request aborted.';
                    } else {
                        msg = 'Uncaught Error.\n' + jqXHR.responseText;
                    }
                    console.log(msg);
                }

            });
        }
    }

    $(window).load(function(){

        igj_jobs.init();

    });

});


