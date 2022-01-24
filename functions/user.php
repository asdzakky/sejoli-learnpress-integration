<?php
/**
 * Get user purchased courses
 * @since   1.0.0
 * @param   integer $user_id
 * @return  array   Purchased courses detail
 */
function sejolilp_get_user_purchased_courses($user_id = 0) {

    $courses = array();
    $profile = learn_press_get_profile($user_id);
    $user    = learn_press_get_user( $user_id );
    $query   = $profile->query_courses( 'purchased' );

    if( $query['items'] ) :

        foreach($query['items'] as $user_course) :

            $course_data = $user->get_course_data( $user_course );

            if ( $course_data ) {
                $courses[] = array(
                    'id'         => $user_course ?? '',
                    'graduation' => ! empty( $course_data->get_graduation() ) ? $course_data->get_graduation() : '',
                    'status'     => ! empty( $course_data->get_status() ) ? $course_data->get_status() : '',
                    'start_time' => lp_jwt_prepare_date_response( $course_data->get_start_time() ? $course_data->get_start_time()->toSql( false ) : '' ),
                    'end_time'   => lp_jwt_prepare_date_response( $course_data->get_end_time() ? $course_data->get_end_time()->toSql( false ) : '' ),
                    'expiration' => lp_jwt_prepare_date_response( $course_data->get_expiration_time() ? $course_data->get_expiration_time()->toSql( false ) : '' ),
                    'results'    => $course_data->calculate_course_results(),
                );
            }

        endforeach;

    endif;

    return $courses;

}
