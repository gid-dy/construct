<?php use App\Services; ?>
<form action="{{ url('/service-filter') }}" method="post">
                @csrf
                @if(!empty($CategoryName))
                <input name="CategoryName" value="{{ $CategoryName }}" type="hidden">
            @endif
            <div class="widget">
                <h4 class="title"><span>Services</span></h4>
                <div class="left_sidebar_area">
                        <aside class="left_widgets p_filter_widgets">
                            <div class="l_w_title">
                             <h3>Browse Services</h3>
                            </div>
                            <div class="widgets_inner">
                                    <ul class="list">
                                        @foreach($servicecategory  as $cat)
                                            <li>
                                                <?php $servicesCount = Services::servicesCount($cat->id); ?>
                                                @if($cat->CategoryStatus=="1")
                                                    <a href="{{ url('/serve/'.$cat->CategoryName) }}" class="">
                                                       
                                                           {{ $cat->CategoryName }}<span class="pull-right"> ({{ $servicesCount }})</span>
                                                            
                                                     
                                                    </a>
                                                    
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                            </div>
                       </aside>
                </div>
            </div>
</form>


