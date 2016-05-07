<?php

return [
    'nextActive' => '<li class="paginate_button next"><a href="{{url}}"><i class="fa fa-angle-right"></i></a></li>',
    'nextDisabled' => '<li class="paginate_button next disabled"><a href="#!"><i class="fa fa-angle-right"></i></a></li>',
    'prevActive' => '<li class="paginate_button previous"><a href="{{url}}"><i class="fa fa-angle-left"></i></a></li>',
    'prevDisabled' => '<li class="paginate_button previous disabled"><a href="#!"><i class="fa fa-angle-left"></i></a></li>',
    'first' => '<li class="paginate_button previous"><a href="{{url}}"><i class="fa fa-angle-double-left"></i></a></li>',
    'last' => '<li class="paginate_button next"><a href="{{url}}"><i class="fa fa-angle-double-right"></i></a></li>',
    'number' => '<li class="paginate_button"><a href="{{url}}">{{text}}</a></li>',
    'current' => '<li class="paginate_button active"><a href="{{url}}">{{text}}</a></li>',
    'ellipsis' => '<li class="paginate_button disabled">...</li>',
    'counterRange' => '{{start}} ' . __('to') . ' {{end}} ' . __('of') . ' {{count}} ' . __('records'),
    'counterPages' => '{{page}} ' . __('of') . ' {{pages}}',
    'sort' => '<a class="sort" href="{{url}}">{{text}}</a>',
    'sortAsc' => '<a class="asc" href="{{url}}">{{text}}</a>',
    'sortDesc' => '<a class="desc" href="{{url}}">{{text}}</a>',
];
