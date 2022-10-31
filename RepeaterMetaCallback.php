<?php

/**
 * @package DwqPlugin
 */

class RepeaterMetaCallback
{
    public function single_repeatable_meta_box_callback($post)
    {
        $single_repeater_group = get_post_meta($post->ID, 'single_repeater_group', true);
        wp_nonce_field(
            'single_repeater_meta_boxes_data',
            'single_repeater_meta_boxes_nonce'
        );
?>
        <script type="text/javascript">
            function addSelect() {
                const tbody = document.querySelector("#repeatable-fieldset-one > tbody");
                const row = document.querySelectorAll(
                    "tbody > .empty-row.custom-repeater-text"
                )[0];
                const clone = row.cloneNode(true);
                new_row = tbody.appendChild(clone);
                const my_class = new_row.classList;
                my_class.remove("empty-row", "custom-repeater-text");
                my_class.add("table-row");
            }

            function deleteRow(r) {
                let i = r.parentNode.parentNode.rowIndex;
                document.getElementById("repeatable-fieldset-one").deleteRow(i);
            }
        </script>

        <table id="repeatable-fieldset-one" width="100%">
            <tbody>
                <?php
                if ($single_repeater_group) :
                    foreach ($single_repeater_group as $field) {
                ?>
                        <tr>
                            <td>
                                <input type="text" style="width:98%;" name="title[]" value="<?php if ($field['title'] != '') echo esc_attr($field['title']); ?>" placeholder="Heading" />
                            </td>
                            <td>
                                <input type="text" style="width:98%;" name="tdesc[]" value="<?php if ($field['tdesc'] != '') echo esc_attr($field['tdesc']); ?>" placeholder="Description" />
                            </td>
                            <td>
                                <a class="button remove-row" href="#1">Remove</a>
                            </td>
                        </tr>
                    <?php } endif; ?>
                <tr class="empty-row custom-repeter-text" style="display: none">
                    <td>
                        <input type="text" style="width:98%;" name="title[]" placeholder="Heading" />
                    </td>
                    <td>
                        <input type="text" style="width:98%;" name="tdesc[]" value="" placeholder="Description" />
                    </td>
                    <td>
                        <a class="button remove-row" href="#">Remove</a>
                    </td>
                </tr>

            </tbody>
        </table>
        <p><a id="add-row" class="button" href="#">Add another</a></p>
<?php
    }
}
