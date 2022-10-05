<?php 

acf_form_head();
?>

<div class="theme-form">
    <?php
        acf_form(array(
            'post_id'       => 'new_post',
            'post_title'    => true,
            'post_excerpt'    => true,
            'new_post'      => array(
                'post_type'     => 'course',
                'post_status'   => 'publish'
            ),
            'submit_value'  => 'Create new course',
            'return' => '%post_url%'
        ));     
    ?>
    <form id="acf-form" class="acf-form" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-4 ml-auto pl-md-0 mb-3 mb-md-0">
                <div class="theme-content__button-group">
                    <button>Bewaar sss</button>
                    <button type="submit">Publiceer</button>
                </div>
            </div>
        </div>
        <div class="row acf-fields acf-form-fields -top">
            <div class="col-md-8 pr-md-0">
                <div class="theme-content__center">
                    <div class="theme-content__upload acf-field acf-field-file acf-field-610f19a34af16">
                        import afbeelding
                        <input name="preview" type="file" key="field_610f19a34af16">
                    </div>
                    <div class="theme-content__small-input">
                        <input name="title" type="text" placeholder="Titel van cursus">
                    </div>
                    <div class="theme-content__medium-input">
                        <textarea name="excerpt" placeholder="korte beschrijving"></textarea>
                    </div>
                    <div class="theme-content__large-input">
                        <div class='theme-content__input-title'>
                            Uitgebreide beschrijving
                        </div>
                        <textarea name="content" placeholder="beschrijf hoe de cursus er uitziet"></textarea>
                    </div>
                    <div class="theme-content__large-input">
                        <div class='theme-content__input-title'>
                            Agenda / programma
                        </div>
                        <input type="date" placeholder="beschrijf het programma van de cursus">
                    </div>
                    <div class="theme-content__small-input">
                        <div class='theme-content__input-title'>
                            Price 
                        </div>
                        <input type="number" name="price">
                    </div>
                    <div class="theme-content__large-input">
                        <div class='theme-content__center__input-title'>
                            Voor wie
                        </div>
                        <textarea placeholder="Voor wie is deze cursus relevant"></textarea>
                    </div>
                    <div class="theme-content__large-input">
                        <div class='theme-content__center__input-title'>
                            Resultaten
                        </div>
                        <textarea placeholder="wat heb je na afloop geleerd en kan je beter dan voorheen"></textarea>
                    </div>

                </div>
            </div>
            <div class="col-md-4 pl-md-0">
                <div class="theme-content__side">
                    <div class="theme-content__dropdown-large">
                        <select name="degree">
                            <option>cursus</option>
                            <option value="MBO2">MBO2</option>
                            <option value="MBO3">MBO3</option>
                            <option value="MBO4">MBO4</option>
                            <option value="HBO">HBO</option>
                            <option value="Universiteit">Universiteit</option>
                        </select>
                    </div>
                    <div class="theme-content__dropdown-large">
                        <select name="">
                            <option>Incompany mogelijkheid</option>
                        </select>
                    </div>
                    <div class="theme-content__dropdown-large">
                        <select name="invisible">
                            <option>Voor extern of intern zichtbaar</option>
                            <option>Intern</option>
                            <option>Public</option>
                        </select>
                    </div>
                    <div class="theme-content__dropdown-large">
                        <select name="coursetype">
                            <option>Type course</option>
                            <option value="Opleidingen">Opleidingen</option>
                            <option value="Workshop">Workshop</option>
                            <option value="E-learning">E-learning</option>
                            <option value="Event">Event</option>
                            <option value="Masterclass">Masterclass</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>  
    </form>
</div>

<?php 

get_footer();

?>