import { Button } from '@wordpress/components';
import styled from '@emotion/styled';
import { NoImageIcon } from '../icons/NoImage';

const StyledImage = styled.img`
  max-height: 50px;
`;

const dashboardTableTransformer = (data, onEditButtonClick, onDeleteButtonClick) => data?.map((el) => ({
  thumbnail: el?.mainImageURL
    ? <StyledImage src={el.mainImageURL} alt={el?.title} />
    : <NoImageIcon width={50} height={50} />,
  name: el?.title,
  edit: <Button isSmall variant="tertiary" onClick={() => onEditButtonClick(el.id)}>Edit</Button>,
  delete: <Button isSmall variant="tertiary" onClick={() => onDeleteButtonClick(el.id)}>Delete</Button>,
}));

export default dashboardTableTransformer;
