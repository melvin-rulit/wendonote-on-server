<?php
$checkAuth = Auth::check();
$jobs = $job_category->Notes();

$jobs = $jobs->get();
?>

<? if($checkAuth) {?>
@foreach($jobs as $job)
    <span class="b_spsdl" jobid="{{ $job->id }}" @if($job->done == true)style="opacity: 0.6;"@endif>
                                @if($checkAuth == true)
            <a class="sps_txt" jobid="{{ $job->id }}" href="/sv......" @if($job->done == true)style="text-decoration: line-through;"@endif>{{ $job->name }}</a>
        @else
            <a class="sps_txt_redirect" href="{{route('login')}}">{{ $job->name }}</a>
        @endif

        <br>

        @if($checkAuth == true)
                                        @if($job->default_job_id != null)
                                            <a class="sps_txt1" href="{{$job->Default_Job->link_href}}">{{ $job->Default_Job->link_name }}</a>
                                        @endif
        @else
            <a class="sps_txt1" href="{{ route('login')}}">{{ $job->link_name }}</a>
        @endif
        {{-- <a href="#" class="btn-done tooltip-holder green">--}}

                                    @if($job->done == true)
                                        <a href="#" class="btn-done tooltip-holder green">

                                            <span class="tooltip">Вернуть в список</span>
                                                done
                                        </a>
                                        <a href="#" class="btn-delete tooltip-holder">
                                            <span class="tooltip">Удалить</span>
                                                delete
                                        </a>
                                    @else
                                        <a href="#" class="btn-done tooltip-holder">

                                            <span class="tooltip">Отметить сделанным</span>
                                                done
                                        </a>
                                        <a href="#" class="btn-delete tooltip-holder">
                                            <span class="tooltip">Удалить</span>
                                                delete
                                        </a>
                                    @endif

							</span>

    @endforeach

    <?}?>