import { Dashicon } from '@wordpress/components';

const TABLE_HEADINGS = [
  {
    accessor: 'thumbnail',
    title: <Dashicon icon="format-image" />,
  },
  {
    accessor: 'name',
    title: 'Name',
  },
  {
    accessor: 'edit',
    title: 'Edit',
  },
  {
    accessor: 'delete',
    title: 'Delete',
  },
];

export default TABLE_HEADINGS;
