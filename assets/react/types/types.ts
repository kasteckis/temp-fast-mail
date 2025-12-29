export interface TemporaryEmailBox {
  email: string;
  uuid: string;
}

export interface ReceivedEmailResponseListDto {
  uuid: string;
  real_from: string;
  real_to: string;
  from_name: string | null;
  subject: string;
  received_at: Date;
}

export interface ReceivedEmailResponseDto {
  uuid: string;
  real_from: string;
  real_to: string;
  from_name: string | null;
  subject: string;
  html: string | null;
  received_at: Date;
}
