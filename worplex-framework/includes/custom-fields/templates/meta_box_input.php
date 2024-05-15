<?php

WORPLEX_CFS()->form->load_assets();

echo WORPLEX_CFS()->form( [
    'post_id'       => $post->ID,
    'field_groups'  => $metabox['args']['group_id'],
    'front_end'     => false,
] );
